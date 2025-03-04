# Usa un'immagine base con PHP e Apache
FROM php:8.2-apache

# Installa le dipendenze necessarie per Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql zip

# Abilita il modulo Apache rewrite
RUN a2enmod rewrite

# Copia i file del progetto nella cartella /var/www/html
COPY . /var/www/html

# Imposta i permessi per la cartella di storage
RUN chown -R www-data:www-data /var/www/html/storage

# Installa Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installa le dipendenze di Composer
RUN composer install --optimize-autoloader --no-dev

# Configura Apache per servire la directory public di Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Configura ServerName per evitare avvisi
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Esponi la porta 80
EXPOSE 80

# Avvia Apache
CMD ["apache2-foreground"]