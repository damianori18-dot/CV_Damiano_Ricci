#!/usr/bin/env bash
set -e

echo "Configurazione permessi cartelle storage..."
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "Pulizia della cache di configurazione..."
php artisan config:clear

echo "Esecuzione delle migrazioni del database..."
php artisan migrate --force

echo "Pulizia delle cache applicative..."
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "Rigenerazione della cache ottimizzata..."
php artisan route:cache
php artisan view:cache
