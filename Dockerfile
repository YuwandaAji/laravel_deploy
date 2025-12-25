# =========================
# Base Image
# =========================
FROM php:8.4-cli

# =========================
# Install system dependencies
# =========================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install zip pdo pdo_mysql pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# =========================
# Install Composer
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================
# Set working directory
# =========================
WORKDIR /app

# =========================
# Copy project files
# =========================
COPY . .

# =========================
# Install PHP dependencies
# =========================
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# =========================
# Laravel setup
# =========================
RUN php artisan key:generate || true \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# =========================
# Expose Railway port
# =========================
EXPOSE 8080

# =========================
# Run Laravel
# =========================
CMD php artisan serve --host=0.0.0.0 --port=8080
