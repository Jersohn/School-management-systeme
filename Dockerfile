FROM php:7.4-fpm

# Clone repository directly
ARG GITHUB_REPO
RUN apt-get update && apt-get install -y git unzip && \
    git clone https://github.com/Jersohn/School-management-systeme.git /var/www && \
    rm -rf /var/www/.git

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

CMD ["php-fpm"]