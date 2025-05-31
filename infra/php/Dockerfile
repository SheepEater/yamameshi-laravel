############################################
# 1) “assets” ステージ：Node.js + Vite/Tailwind のビルド
############################################
FROM node:18 AS assets

WORKDIR /app

# 1.1) package.json と package-lock.json を先にコピー
COPY src/package.json        ./
COPY src/package-lock.json   ./

# 1.2) Vite/Tailwind/PostCSS の設定ファイルをコピー
COPY src/vite.config.js       ./
COPY src/postcss.config.cjs   ./
COPY src/tailwind.config.js   ./

# 1.3) Laravel 側のリソースと public フォルダをコピー
#      → Vite のビルド先 public/build の親に public フォルダが必要なので
#         先に public と resources を置く
COPY src/resources        resources
COPY src/public           public

# 1.4) Node モジュールをインストールしてビルド
RUN npm install
RUN npm run build

# これで /app/public/build に
#   - assets/app-*.css/js  
#   - assets/home-*.css  
#   - assets/post-card-*.css  
#   - assets/header-*.css  
#   - assets/search-*.css  
#   などが生成されているはずです。


############################################
# 2) “app” ステージ：PHP + Composer + Laravel + SQLite
############################################
FROM php:8.2-fpm-buster

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

# 2.1) OSパッケージ & PHP 拡張 のインストール
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

# 2.2) PHP 設定ファイルをコピー（必要に応じて修正した php.ini）
COPY infra/php/php.ini /usr/local/etc/php/php.ini

# 2.3) 作業ディレクトリを /data に変更
WORKDIR /data

# 2.4) Composer バイナリをコピー
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# 2.5) “assets” ステージ でビルドした public/build を先にコピー
#      → これにより最終イメージにはビルド済みの CSS/JS が含まれる
COPY --from=assets /app/public/build public/build

# 2.6) Laravel 本体およびその他のソースコードをコピー
#      → この時点で artisan が /data/artisan として存在するようになる
COPY src/. /data

# 2.7) composer.json と composer.lock はすでに src 以下に含まれているので、
#       2.6 コピー時点で /data/composer.json と /data/composer.lock がある状態です。
#       そのまま composer インストールを実行します。
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# 2.8) SQLite 用ディレクトリとデータベースファイル作成
RUN mkdir -p database \
 && touch database/database.sqlite \
 && chmod -R 0777 database

# 2.9) ストレージへのシンボリックリンク作成
RUN php artisan storage:link

# 2.10) マイグレーションを実行してからサーバー起動
EXPOSE 8080
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
