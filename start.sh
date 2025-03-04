#!/bin/sh

# Avvia PHP-FPM in background
php-fpm &

# Avvia Nginx in foreground
nginx -g 'daemon off;'