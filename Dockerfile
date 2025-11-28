FROM php:8.3-fpm AS base

# System packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev libcurl4-openssl-dev libssl-dev \
    zlib1g-dev libicu-dev g++ procps \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath sockets intl

# Node.js 18 (Vite compatible) and Yarn installation
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g yarn

# Composer installation
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files and artisan file
COPY composer.json composer.lock artisan ./

# Create Laravel's basic directory structure
RUN mkdir -p bootstrap/cache storage/app storage/framework/cache/data \
    storage/framework/sessions storage/framework/views storage/logs

# Install Composer dependencies (without post-scripts)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Copy the rest of the project files
COPY . .

# Run Composer post-scripts
RUN composer dump-autoload --optimize

# Laravel config cache (to be done at runtime, not during build)
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

# File permissions
RUN chown -R www-data:www-data /var/www \
 && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

# Configure PHP-FPM to listen on port 9000
RUN sed -i 's/listen = \/run\/php\/php8.3-fpm.sock/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf

# Startup script to cache Laravel configs and start PHP-FPM
CMD ["sh", "-c", "php artisan config:cache 2>/dev/null || php artisan config:clear && php artisan route:cache 2>/dev/null || true && php artisan view:cache 2>/dev/null || true && php-fpm"]
