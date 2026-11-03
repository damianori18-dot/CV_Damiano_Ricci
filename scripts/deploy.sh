#!/usr/bin/env bash
echo "Generazione della cache di configurazione..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Esecuzione delle migrazioni del database..."
php artisan migrate --force
