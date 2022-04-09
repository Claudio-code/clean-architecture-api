FROM php:8.1-fpm-bullseye

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y git libicu-dev zlib1g-dev libzip-dev

RUN docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data

COPY --chown=www-data:www-data ./composer.json ./composer.lock ./symfony.lock /var/www/

WORKDIR /var/www

RUN rm -rf /var/www/html && ln -s public html

USER www-data

EXPOSE 9000

ENTRYPOINT ["./docker/entrypoint.sh"]
