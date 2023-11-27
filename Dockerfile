FROM php:8.1-fpm

RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev zip unzip && \
    docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# Installer Node.js et npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs npm
WORKDIR /var/www
COPY . .

RUN cp -n .env .env

# Installation et configuration de votre site pour la production
# https://laravel.com/docs/8.x/deployment#optimizing-configuration-loading
RUN composer install && npm install
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan migrate
RUN chmod -R 777 storage
RUN npm run build