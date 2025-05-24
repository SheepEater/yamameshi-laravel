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

# プロジェクトルートのすべてのファイルをイメージ内 /data にコピー
COPY src/. .

RUN composer install --no-dev --optimize-autoloader

RUN npm ci && npm run build


# ④ ポート公開・起動コマンド
EXPOSE 8080
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8080"]