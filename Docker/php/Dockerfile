FROM php:8.3-fpm
WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && \
    apt-get install -y libpq-dev \
        && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-install pdo pdo_pgsql pgsql

RUN pecl install xdebug-3.3.1
RUN docker-php-ext-enable xdebug

RUN apt-get update && \
    apt-get install -y unzip
