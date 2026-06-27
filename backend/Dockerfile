FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql intl zip opcache \
    && a2enmod rewrite headers

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock symfony.lock ./
RUN composer config --global process-timeout 2000
RUN composer install --no-dev --optimize-autoloader --no-scripts --prefer-source

COPY . .

RUN composer dump-autoload --optimize --no-dev \
    && php bin/console cache:clear --env=prod || true \
    && chown -R www-data:www-data var \
    && chmod -R 775 var

RUN composer dump-autoload --optimize --no-dev \
    && php bin/console cache:clear --env=prod || true

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf
    

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN cat > /etc/apache2/sites-available/000-default.conf <<'EOF'
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        AllowOverride All
        Require all granted
        FallbackResource /index.php
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF

RUN rm -rf var/cache/prod \
    && mkdir -p var/cache/prod var/log \
    && chown -R www-data:www-data var \
    && chmod -R 777 var

EXPOSE 80