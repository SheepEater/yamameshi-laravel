############################################
# 1) “assets” ステージ：Node.js＋ViteでCSS/JSをビルドする
############################################
FROM node:18 AS assets

# 作業ディレクトリを /app に設定
WORKDIR /app

# 1-1) package.json / package-lock.json をコピーして、依存関係をインストール
COPY src/package.json src/package-lock.json ./
# (もし存在するなら vite/postcss/tailwind の設定ファイルも同階層にコピー)
COPY src/vite.config.js      ./
COPY src/postcss.config.js   ./
COPY src/tailwind.config.js  ./

# 1-2) Laravel のリソースディレクトリと public ディレクトリをコピー
#      → Vite は default で `public/build` に出力するため、public フォルダが先にある必要がある
COPY src/resources        resources
COPY src/public           public

# 1-3) 依存関係を lock-file に合わせてインストールし、ビルド
RUN npm ci 
RUN npm run build

# ここまでで、 `/app/public/build` にビルド済みの CSS/JS (Tailwind + Vite 出力) が生成されている

############################################
# 2) “app” ステージ：PHP + Composer + Laravel + SQLite を準備する
############################################
FROM php:8.2-fpm-buster

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

# 2-1) OSパッケージのインストール & PHP拡張モジュールのビルド
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    procps \
    libpng-dev \
    nodejs \
 && docker-php-ext-install intl pdo_mysql zip bcmath \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# 2-2) PHP 設定ファイルをコピー（必要に応じて調整）
COPY infra/php/php.ini /usr/local/etc/php/php.ini

# 作業ディレクトリを /data に設定
WORKDIR /data

# 2-3) Composer バイナリをコピー
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# 2-4) composer.json と composer.lock を先にコピー → PHP の依存をインストール
COPY src/composer.json src/composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# 2-5) “assets” ステージ でビルドされた public/build をこちらにコピー
#      → これにより、Tailwind/Vite で生成された CSS/JS が /data/public/build に配置される
COPY --from=assets /app/public/build public/build

# 2-6) Laravel 本体およびその他のソースコードをコピー（resources/js, resources/css は使われないため丸ごとコピーOK）
COPY src/. /data

# 2-7) SQLite 用ディレクトリとファイルを作成
RUN mkdir -p database \
 && touch database/database.sqlite \
 && chmod -R 0777 database

# 2-8) ストレージへのシンボリックリンク作成
RUN php artisan storage:link

# 2-9) 必要であればマイグレーションを実行してからサーバー起動
EXPOSE 8080
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
