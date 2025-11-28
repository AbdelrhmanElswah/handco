FROM php:8.3-cli AS base

# System packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libwebp-dev \
    zlib1g-dev \
    libicu-dev \
    g++ \
    libevent-dev \
    procps \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        sockets \
        intl \
        gd \
        mysqli

# Swoole is installed from GitHub
RUN curl -L -o swoole.tar.gz https://github.com/swoole/swoole-src/archive/refs/tags/v5.1.0.tar.gz \
    && tar -xf swoole.tar.gz \
    && cd swoole-src-5.1.0 \
    && phpize \
    && ./configure \
    && make -j"$(nproc)" \
    && make install \
    && docker-php-ext-enable swoole

# Node.js 18 (optional – you can remove if you don't build frontend assets in the image)
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

# If you need JS build later, uncomment and make sure scripts exist in package.json:
# COPY package.json package-lock.json ./
# RUN npm ci
# RUN npm run build

# Copy the rest of the project files
COPY . .

# Optimize autoload
RUN composer dump-autoload --optimize

# Clear caches at build time – don't fail the build if these break
RUN php artisan config:clear || true \
 && php artisan route:clear || true \
 && php artisan view:clear || true

# File permissions
RUN chown -R www-data:www-data /var/www \
 && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

# Startup script
RUN printf '%s\n' \
"#!/bin/bash" \
"set -e" \
"echo \"[START] Laravel container boot\"" \
"echo \"APP_ENV: \${APP_ENV}\"" \
"echo \"APP_DEBUG: \${APP_DEBUG}\"" \
"echo \"APP_URL: \${APP_URL}\"" \
"" \
"echo \"[INFO] Running cache commands...\"" \
"php artisan config:cache || echo \"[WARN] config:cache failed (check env)\"" \
"php artisan route:cache || echo \"[WARN] route:cache failed\"" \
"php artisan view:cache || echo \"[WARN] view:cache failed\"" \
"" \
"echo \"[INFO] Starting Octane on 0.0.0.0:9000...\"" \
"php artisan octane:start --server=swoole --host=0.0.0.0 --port=9000 || {" \
"  echo \"[ERROR] Octane failed to start. Falling back to php artisan serve...\";" \
"  php artisan serve --host=0.0.0.0 --port=9000;" \
"}" \
> /start.sh && chmod +x /start.sh

CMD ["/start.sh"]
