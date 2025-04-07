# Dockerfile

# --- Stage 1: Builder ---
# Usa un'immagine Node per compilare gli asset
FROM node:20-alpine AS builder

WORKDIR /app

# Installa dipendenze necessarie per alcune build npm (opzionale, dipende dai tuoi asset)
# RUN apk add --no-cache python3 make g++

# Copia i file di definizione delle dipendenze
COPY package.json package-lock.json ./

# Installa le dipendenze npm
RUN npm ci --omit=dev --no-audit --no-fund

# Copia il resto del codice sorgente (necessario per Vite/Mix)
COPY . .

# Compila gli asset per la produzione
RUN npm run build

# Rimuovi node_modules dopo la build per pulizia (opzionale)
# RUN rm -rf node_modules

# --- Stage 2: Applicazione Finale ---
# Usa l'immagine PHP 8.2 FPM basata su Alpine
FROM php:8.2-fpm-alpine AS app

# Variabili d'ambiente per la configurazione non interattiva
ENV ACCEPT_EULA=Y

# Aggiorna i pacchetti e installa le dipendenze di sistema richieste
# build-base è necessario per compilare alcune estensioni
# nginx per il web server
# libzip, libpng, libjpeg, freetype per le estensioni PHP comuni
# supervisor se vuoi gestire i processi con esso (alternativa a entrypoint.sh semplice)
RUN apk update && apk add --no-cache \
    build-base \
    nginx \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    supervisor \
    && rm -rf /var/cache/apk/*

    
# Installa le estensioni PHP necessarie per Laravel
# gd richiede libpng, libjpeg, freetype
# bcmath, pdo_mysql, zip, exif sono comuni per Laravel
# sockets può servire per Livewire/Reverb o code future
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    bcmath \
    pdo_pgsql \
    zip \
    exif \
    sockets

# Installa Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Imposta la directory di lavoro
WORKDIR /var/www/html

# Copia composer.json e composer.lock prima del resto per sfruttare la cache Docker
COPY composer.json composer.lock ./

# Installa le dipendenze PHP senza i pacchetti dev e ottimizza l'autoloader
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --optimize-autoloader

# Copia la configurazione di Nginx
COPY .docker/nginx/default.conf /etc/nginx/http.d/default.conf
# Rimuovi la configurazione di default di Nginx se presente
RUN rm -f /etc/nginx/nginx.conf

# Copia lo script di entrypoint e rendilo eseguibile
COPY .docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copia gli asset compilati dallo stage 'builder'
COPY --from=builder /app/public/build ./public/build

# Copia il resto dell'applicazione (assicurati che .dockerignore sia corretto!)
COPY . .

# Imposta i permessi corretti per Laravel (nginx/php-fpm usano www-data su Alpine)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Esponi la porta 80 (quella su cui Nginx ascolterà)
EXPOSE 80

# Definisci l'entrypoint per avviare i servizi
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Comando di default (viene eseguito dall'entrypoint)
# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"] # Se usi supervisor
# Il nostro entrypoint.sh gestisce l'avvio, quindi non serve CMD qui