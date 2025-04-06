#!/bin/sh

# Script: .docker/entrypoint.sh

set -e # Esce immediatamente se un comando fallisce

echo "Running entrypoint script..."

# Esegui le ottimizzazioni di Laravel (opzionale, ma consigliato)
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache

echo "Starting PHP-FPM..."
php-fpm & # Avvia PHP-FPM in background

echo "Starting Nginx..."
# Avvia Nginx in foreground (questo mantiene il container attivo)
exec nginx -g 'daemon off;'