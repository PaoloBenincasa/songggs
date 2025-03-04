# Usa un'immagine base con PHP e Apache
FROM php:8.2-apache

# Installa le dipendenze necessarie per Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql zip

# Abilita il modulo Apache rewrite
RUN a2enmod rewrite

# Configura Apache per servire la directory public di Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

# Configura ServerName per evitare avvisi
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Abilita i log di errore di Apache
RUN echo "ErrorLog /var/log/apache2/error.log" >> /etc/apache2/apache2.conf
RUN echo "LogLevel debug" >> /etc/apache2/apache2.conf

# Imposta la directory di lavoro
WORKDIR /var/www/html

# Copia i file del progetto nella cartella /var/www/html
COPY . .

# Imposta i permessi per le cartelle di storage e bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Installa Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installa le dipendenze di Composer (senza dipendenze di sviluppo)
RUN composer install --optimize-autoloader --no-dev

# Esponi la porta 80
EXPOSE 80

# Avvia Apache
CMD ["apache2-foreground"]