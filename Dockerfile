# ==============================
# Base image: PHP 8.2 + FPM
# ==============================
FROM php:8.2-fpm

# ==============================
# Install system dependencies & PHP extensions
# ==============================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ==============================
# Install Composer (global)
# ==============================
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

# ==============================
# Install Node.js (buat Vite)
# ==============================
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# ==============================
# Set working directory
# ==============================
WORKDIR /var/www/html

# ==============================
# Copy semua file project ke container
# (pastikan .env TIDAK di-commit ke GitHub)
# ==============================
COPY . .

# ==============================
# Install dependency PHP (Laravel)
# ==============================
RUN composer install --no-dev --optimize-autoloader --no-interaction

# ==============================
# Install dependency NPM & build Vite
# ==============================
RUN npm install
RUN npm run build

# ==============================
# Permission untuk storage & cache Laravel
# ==============================
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ==============================
# Bersihkan cache Laravel & buat storage:link
# (tidak butuh koneksi DB)
# ==============================
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan storage:link || true

# ==============================
# Expose port (Railway pakai env $PORT,
# tapi kita pakai default 8080 jika tidak ada)
# ==============================
EXPOSE 8080

# ==============================
# CMD: Jalankan migrate pakai env Railway,
# lalu start Laravel dev server
# ==============================
CMD sh -c "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"
