FROM php:8.2-fpm-buster

ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer \
  # メモリ不足回避
  COMPOSER_MEMORY_LIMIT=-1 

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  # apt-get -y install --no-install-recommends git unzip libzip-dev libicu-dev libonig-dev procps && \
  # apt-get clean && \
  # rm -rf /var/lib/apt/lists/* && \
  # docker-php-ext-install intl pdo_mysql zip bcmath
  apt-get -y install --no-install-recommends \
  git unzip libzip-dev libicu-dev libonig-dev procps \
  libxml2-dev \
  libpng-dev \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-install \
    gd \
    intl \
    pdo_mysql \
    zip \
    bcmath \
    mbstring \
    xml

RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install -y nodejs

# COPY ./php.ini /usr/local/etc/php/php.ini
COPY infra/php/php.ini /usr/local/etc/php/php.ini

# 作業ディレクトリを /data に設定
WORKDIR /data

# アプリ本体を src/ 配下から /data にコピー
COPY src/. /data

# composer.json / lock をコピー
COPY src/composer.json src/composer.lock /data/
# デバッグ付きでインストール
RUN composer install \
  --no-dev \
  --optimize-autoloader \
  --no-interaction \
  --prefer-dist

# （必要であれば）npm などフロント資産のビルド
RUN npm ci && npm run build

# Render のデフォルト要求ポートに合わせる
EXPOSE 8080

# このディレクトリ (/data) で artisan serve を実行
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=${PORT}"]