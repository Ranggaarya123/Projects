# Gunakan image dasar PHP dengan Apache
FROM php:8.2-apache

# Update package list dan install libssl serta dependensi lainnya
RUN apt-get update && apt-get install -y libssl1.0 libssl-dev

# Copy semua file dari folder proyek ke /var/www/html di container
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Jalankan Composer install
RUN composer install --no-dev --optimize-autoloader

# Set permission untuk Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 untuk Apache
EXPOSE 80
