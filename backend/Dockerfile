# Stage 1: Build stage
FROM php:8.2-fpm-alpine as builder

# Install system dependencies
RUN apk add --no-cache \
    curl \
    git \
    build-base \
    autoconf \
    openssl-dev \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    gd \
    bcmath \
    ctype \
    json \
    mbstring \
    openssl \
    tokenizer \
    xml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock* ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Stage 2: Runtime stage
FROM php:8.2-fpm-alpine

# Install runtime dependencies only
RUN apk add --no-cache \
    postgresql-libs \
    libpng \
    libjpeg-turbo \
    freetype \
    curl \
    git

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    gd \
    bcmath \
    ctype \
    json \
    mbstring \
    openssl \
    tokenizer \
    xml

# Set working directory
WORKDIR /var/www/html

# Copy from builder stage
COPY --from=builder /var/www/html /var/www/html
COPY --from=builder /usr/local/bin/composer /usr/local/bin/composer

# Copy application code
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Create storage directories
RUN mkdir -p storage/logs storage/framework/{cache,sessions,views} && \
    chown -R www-data:www-data storage bootstrap

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port
EXPOSE 9000

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD php -r "exit((file_exists('/var/www/html/storage/logs/laravel.log')) ? 0 : 1);"

# Start PHP-FPM
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
