FROM php:8.2-fpm-buster

ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  apt-get -y install --no-install-recommends git unzip libzip-dev libicu-dev libonig-dev procps && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath

RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install -y nodejs

# COPY ./php.ini /usr/local/etc/php/php.ini
COPY infra/php/php.ini /usr/local/etc/php/php.ini

# 作業ディレクトリを /data に設定
WORKDIR /data

# プロジェクトルートのすべてのファイルをイメージ内 /data にコピー
COPY . /data

# 依存関係のインストール
RUN composer install --no-dev --optimize-autoloader

# （必要であれば）npm などフロント資産のビルド
RUN npm ci && npm run build

# Render のデフォルト要求ポートに合わせる
EXPOSE 8080

# このディレクトリ (/data) で artisan serve を実行
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]