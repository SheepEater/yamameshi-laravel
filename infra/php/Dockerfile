############################################
# 1) “assets” ステージ：Node.js + Vite/Tailwind のビルド
############################################
FROM node:18 AS assets

# 作業ディレクトリを /app に
WORKDIR /app

# 1.1) package.json と package-lock.json を先にコピー
#      （もしローカルに package-lock.json がなければ、先にローカルで npm install → lockfile を生成しておくこと）
COPY src/package.json        ./ 
COPY src/package-lock.json   ./

# 1.2) Vite／PostCSS／Tailwind の設定ファイルをコピー
COPY src/vite.config.js      ./  
COPY src/postcss.config.cjs   ./  
COPY src/tailwind.config.js  ./

# 1.3) Laravel の「resources」 と 「public」 をコピー
#      → こうしておくとビルド先の public/build を作成する際に public が存在する
COPY src/resources        resources
COPY src/public           public

# 1.4) npm インストール → Vite ビルド
RUN npm install
RUN npm run build

# この時点で /app/public/build 以下に
#   assets/app-*.css/js
#   assets/home-*.css
#   assets/post-card-*.css
#   assets/header-*.css
#   assets/search-*.css
#   …などが生成されているはずです。


############################################
# 2) “app” ステージ：PHP + Composer + Laravel + SQLite
############################################
FROM php:8.2-fpm-buster

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

# 2.1) OSパッケージ & PHP拡張 のインストール
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

# 2.4) まず Laravel のソース（artisan を含む）をコピー
#      → これで composer install 時に "php artisan package:discover" が実行できる
COPY src/. /data

# 2.5) Composer バイナリをコピー
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# 2.6) composer.json と composer.lock をもとに依存をインストール
#      （Laravel コードがすでに /data 下にコピーされているため、
#        post-autoload-dump 時に artisan がちゃんと存在する）
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# 2.7) “assets” ステージでビルドした public/build をコピー
#      → ここで /data/public/build にビルド済みの CSS/JS が配置される
COPY --from=assets /app/public/build public/build

# 2.8) SQLite 用ディレクトリとデータベースファイル作成
RUN mkdir -p database \
 && touch database/database.sqlite \
 && chmod -R 0777 database

# 2.9) ストレージへのシンボリックリンク作成
RUN php artisan storage:link

# 2.10) ポートを公開＆サーバ起動
EXPOSE 8080
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
