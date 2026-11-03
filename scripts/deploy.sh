#!/usr/bin/env bash
echo "Generazione della cache di configurazione..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Esecuzione delle migrazioni del database..."
# Il pezzo sotto serve a stampare l'errore preciso se le migrazioni falliscono
php artisan migrate --force || { echo "Errore durante php artisan migrate!"; exit 1; }
