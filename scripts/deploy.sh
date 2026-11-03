#!/usr/bin/env bash

echo "Configurazione permessi cartelle storage..."
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

echo "Pulizia di vecchie configurazioni e cache..."
php artisan config:clear
php artisan cache:clear

echo "Esecuzione delle migrazioni del database..."
php artisan migrate --force

echo "Rigenerazione della cache ottimizzata..."
php artisan route:cache
php artisan view:cache
