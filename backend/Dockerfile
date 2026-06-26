FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql intl zip opcache \
    && a2enmod rewrite headers

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock symfony.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

RUN composer dump-autoload --optimize --no-dev \
    && php bin/console cache:clear --env=prod || true

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

EXPOSE 80