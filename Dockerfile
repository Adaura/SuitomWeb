FROM php:8.1-fpm

# Installer les extensions PHP et Composer
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev zip unzip && \
    docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# ... (autres commandes pour PHP et autres dépendances)

# Installer Node.js et npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs npm

# Installation et configuration de votre site pour la production

# Installation dans votre image de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV WEB_DOCUMENT_ROOT /app/public
ENV APP_ENV production
WORKDIR /app
COPY . .

# https://laravel.com/docs/8.x/deployment#optimizing-configuration-loading
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN chmod -R gu+w storage && chmod -R guo+w storage
# Generate security key
RUN php artisan key:generate
# Optimizing Configuration loading
# Optimizing Route loading
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan route:cache
# Optimizing View loading
RUN php artisan view:cache
RUN php artisan m:migration init
# RUN php artisan fill:database
# RUN php artisan serve
# RUN npm run dev
