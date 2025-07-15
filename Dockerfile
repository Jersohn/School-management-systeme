FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure Git safe directory
RUN git config --global --add safe.directory /var/www

# Create www-data user with specific UID/GID (correspondant à l'hôte)
RUN groupmod -g 1000 www-data && \
    usermod -u 1000 www-data

# Set working directory
WORKDIR /var/www

# Copy application files (en préservant les permissions)
COPY --chown=www-data:www-data . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Cleanup
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

CMD ["php-fpm"]