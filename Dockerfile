# Usa un'immagine PHP con estensioni necessarie
FROM php:8.2-fpm

# Installa le dipendenze
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Imposta la working directory
WORKDIR /var/www

# Copia i file del progetto
COPY . .

# Imposta i permessi
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Rendi eseguibile lo script start.sh
RUN chmod +x /start.sh

# Installa le dipendenze Laravel
RUN composer install --no-dev --optimize-autoloader

# Esponi la porta 9000 per PHP-FPM
EXPOSE 9000

# Comando di avvio
CMD ["php-fpm"]

