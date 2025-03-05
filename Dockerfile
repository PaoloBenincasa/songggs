# Usa un'immagine PHP con estensioni necessarie per Laravel
FROM php:8.2-cli

# Installa le dipendenze di sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Copia il codice dell'applicazione nella cartella /var/www/html
COPY . /var/www/html

# Imposta la directory di lavoro
WORKDIR /var/www/html

# Installa Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installa le dipendenze PHP (senza dipendenze di sviluppo)
RUN composer install --optimize-autoloader --no-dev

# Imposta i permessi per le cartelle di storage e cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Esponi la porta 8000 (usata da php artisan serve)
EXPOSE 8000

# Comando di avvio: avvia il server Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]