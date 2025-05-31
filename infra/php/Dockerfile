############################################
# 1) “assets” ステージ：Node.js + Vite/Tailwind のビルド
############################################
FROM node:18 AS assets

WORKDIR /app

# 1.1) package.json と package-lock.json を先にコピー
COPY src/package.json        ./ 
COPY src/package-lock.json   ./

# 1.2) Vite/Tailwind/PostCSS の設定ファイルをコピー
COPY src/vite.config.js      ./  
COPY src/postcss.config.js   ./  
COPY src/tailwind.config.js  ./

# 1.3) Laravel 側のリソースと public フォルダをコピー
#      → こうしておくと、Vite のビルド先 public/build の親フォルダ public が存在する状態になる
COPY src/resources        resources
COPY src/public           public

# 1.4) Node モジュールをインストールしてビルド
#      ロックファイルがずれている場合に `npm ci` だとエラーになってしまうため、ここではあえて `npm install` に置き換え
RUN npm install
RUN npm run build

# これで /app/public/build に
#   - assets/app-*.css/js  
#   - assets/home-*.css  
#   - assets/post-card-*.css  
#   - … などが生成される

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

# 2.2) PHP 設定ファイルをコピー（必要に応じて修正）
COPY infra/php/php.ini /usr/local/etc/php/php.ini

# 2.3) 作業ディレクトリを /data に
WORKDIR /data

# 2.4) Composer バイナリをコピー
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# 2.5) composer.json と composer.lock を先にコピー → PHP の依存をインストール
COPY src/composer.json src/composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# 2.6) “assets” ステージ でビルドした public/build をコピー
#      → ここで /data/public/build にビルド済みの CSS/JS が置かれる
COPY --from=assets /app/public/build public/build

# 2.7) Laravel 本体およびその他のソースコードをコピー
COPY src/. /data

# 2.8) SQLite 用ディレクトリとデータベースファイル作成
RUN mkdir -p database \
 && touch database/database.sqlite \
 && chmod -R 0777 database

# 2.9) ストレージへのシンボリックリンク作成
RUN php artisan storage:link

# 2.10) 必要であればマイグレーションを実行してからサーバー起動
EXPOSE 8080
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
