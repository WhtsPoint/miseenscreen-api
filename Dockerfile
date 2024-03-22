FROM php:8.1-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl git wget zip unzip libzip-dev libxml2-dev libpng-dev libpq-dev vim  \
    && docker-php-ext-install pdo pdo_mysql soap zip opcache gd intl

COPY php-fpm/php.ini /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

USER www-data
WORKDIR /var/www/html

ENV APP_ENV=prod


RUN composer i --no-dev --no-scripts

USER root