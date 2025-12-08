FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apk add --no-cache \
    bash \
    curl \
    git \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip

# Install PHP extensions (tanpa gd dulu untuk simplicity)
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    bcmath \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application code
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
