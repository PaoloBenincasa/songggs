FROM php:8.3-fpm-alpine

# Installa le dipendenze di sistema necessarie per le estensioni PHP
RUN apk add --no-cache --update libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    postgresql-dev \
    libpng-dev \
    linux-headers 

# Installa le estensioni PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd bcmath zip exif sockets pdo pdo_pgsql

# Imposta la directory di lavoro per l'applicazione Laravel
WORKDIR /var/www/html

# Copia i file dell'applicazione
COPY . /var/www/html

# Installa Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia la configurazione di Apache (se necessario, altrimenti rimuovi)
# COPY docker/apache2/default.conf /etc/apache2/sites-available/000-default.conf
# RUN a2enmod rewrite
# RUN service apache2 restart

# Cambia la proprietà della cartella storage (potrebbe essere necessario)
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Genera la chiave dell'applicazione Laravel
RUN php artisan key:generate --ansi

# Esegui le migrazioni (potrebbe essere necessario)
# RUN php artisan migrate --force

# Ottimizza l'autoload di Composer
RUN composer install --optimize-autoloader --no-dev

# --- Stage 2: Builder (Node.js per gli asset) ---
FROM node:20-alpine AS builder

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm install

COPY . .

RUN chmod +x /app/node_modules/.bin/vite

# Compila gli asset per la produzione
RUN npm run build

# --- Stage 3: Final Image ---
FROM php:8.3-fpm-alpine

# Installa le dipendenze necessarie per l'ambiente di produzione (potrebbe essere un subset)
RUN apk add --no-cache --update libzip \
    freetype \
    libjpeg-turbo \
    libpng

# Copia i file dell'applicazione dal primo stage
COPY --from=0 /var/www/html /var/www/html

# Copia gli asset compilati dallo stage del builder
COPY --from=builder /app/public/build /var/www/html/public/build

# Installa Composer (solo runtime, senza dev dependencies)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Cambia la proprietà della cartella storage (potrebbe essere necessario)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Espone la porta 80 (o quella che usi)
EXPOSE 8000

# Comando per avviare il server PHP-FPM
CMD ["php-fpm"]