# FROM php:8.3-fpm-alpine AS base

# # Installa le dipendenze di sistema necessarie per le estensioni PHP
# RUN apk add --no-cache --update libzip-dev \
#     freetype-dev \
#     libjpeg-turbo-dev \
#     postgresql-dev \
#     libpng-dev \
#     linux-headers

# # Installa le estensioni PHP
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install -j$(nproc) gd bcmath zip exif sockets pdo pdo_pgsql

# # Imposta la directory di lavoro per l'applicazione Laravel
# WORKDIR /var/www/html

# # Copia i file dell'applicazione
# COPY . /var/www/html

# # Installa Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Installa le dipendenze PHP
# RUN composer install --optimize-autoloader --no-dev

# # Genera la chiave dell'applicazione Laravel SENZA dipendere da .env
# RUN php -r "file_exists('.env') ? require __DIR__.'/bootstrap/app.php'->loadEnvironmentFrom('.env') : copy('.env.example', '.env');" \
#     && php artisan key:generate --ansi

# # Ottimizza l'autoload di Composer (ridondante, già fatto sopra)
# # RUN composer install --optimize-autoloader --no-dev

# # --- Stage 2: Builder (Node.js per gli asset) ---
# FROM node:20-alpine AS builder

# WORKDIR /app

# COPY package.json package-lock.json ./

# RUN npm install

# COPY . .

# RUN chmod +x /app/node_modules/.bin/vite

# # Compila gli asset per la produzione
# RUN npm run build

# # --- Stage 3: Final Image ---
# FROM php:8.3-fpm-alpine AS final

# # Installa le dipendenze necessarie per l'ambiente di produzione (potrebbe essere un subset)
# RUN apk add --no-cache --update libzip \
#     freetype \
#     libjpeg-turbo \
#     libpng

# # Copia i file dell'applicazione dallo stage 'base'
# COPY --from=base /var/www/html /var/www/html

# # Copia gli asset compilati dallo stage 'builder'
# COPY --from=builder /app/public/build /var/www/html/public/build

# # Installa Composer (solo runtime, senza dev dependencies e senza scripts)
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN composer install --optimize-autoloader --no-dev --no-scripts

# # Cambia la proprietà della cartella storage (potrebbe essere necessario)
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Espone la porta 8000
# EXPOSE 8000

# # Comando per avviare il server PHP-FPM
# CMD ["php-fpm"]

FROM php:8.3-fpm-alpine AS base

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

# Installa le dipendenze PHP
RUN composer install --optimize-autoloader --no-dev

# Genera la chiave dell'applicazione Laravel SENZA dipendere da .env
RUN php -r "file_exists('.env') ? require __DIR__.'/bootstrap/app.php'->loadEnvironmentFrom('.env') : copy('.env.example', '.env');" \
    && php artisan key:generate --ansi

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
FROM php:8.3-fpm-alpine AS final

# Installa le dipendenze necessarie, incluso Nginx
RUN apk add --no-cache --update nginx

# Copia la configurazione di Nginx
COPY .nginx/default.conf /etc/nginx/http.d/default.conf

# Copia lo script di entrypoint
COPY .nginx/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Copia i file dell'applicazione
COPY --from=base /var/www/html /var/www/html

# Copia gli asset compilati
COPY --from=builder /app/public/build /var/www/html/public/build

# Cambia la proprietà della cartella storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Espone la porta 80
EXPOSE 80

# Esegui lo script di entrypoint all'avvio del container
ENTRYPOINT ["/entrypoint.sh"]