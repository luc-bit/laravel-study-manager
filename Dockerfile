FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

COPY . /var/www/html/

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php && \
    php composer.phar install --no-dev --optimize-autoloader

EXPOSE 80
