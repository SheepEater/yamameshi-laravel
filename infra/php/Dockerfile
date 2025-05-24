FROM php:8.2-fpm-buster

ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
  && apt-get install -y --no-install-recommends \
  git unzip libzip-dev libicu-dev libonig-dev procps \
  libpng-dev \
  && docker-php-ext-install intl pdo_mysql zip bcmath \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
  && apt-get install -y nodejs

# COPY ./php.ini /usr/local/etc/php/php.ini
COPY infra/php/php.ini /usr/local/etc/php/php.ini

# 作業ディレクトリを /data に設定
WORKDIR /data
COPY src/package*.json       ./  
COPY src/vite.config.js      ./  
COPY src/postcss.config.js   ./  
COPY src/tailwind.config.js  ./

# Laravel プロジェクトの中にあるフロント資産をコピー
COPY src/resources/js  resources/js
COPY src/resources/css resources/css


# （必要であれば）npm などフロント資産のビルド
RUN npm ci && npm run build

# 4) 残りのアプリケーションコードをまとめてコピー
# COPY src/. .
# アプリ本体を src/ 配下から /data にコピー
COPY src/. /data


RUN cp .env.example .env


# デバッグ付きでインストール
RUN composer install \
  --no-dev \
  --optimize-autoloader \
  --no-interaction \
  --prefer-dist

# composer.json / lock をコピー
# COPY src/composer.json src/composer.lock /data/
COPY src/composer.json src/composer.lock ./

# --- SQLite 用ディレクトリとファイル作成 ---
RUN mkdir -p database \
  && touch database/database.sqlite \
  && chmod -R 0777 database
# --- SQLite 用ディレクトリとファイル作成 ---

RUN php artisan config:cache \
  && php artisan route:cache \
  && php artisan view:cache

# ④ ポート公開・起動コマンド
EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port ${PORT:-8080}
