#!/usr/bin/env bash

echo "Configurazione permessi cartelle storage..."
chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

#!/usr/bin/env bash

echo "Svuotamento totale della cache di configurazione..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "Esecuzione delle migrazioni del database..."
php artisan migrate --force


echo "Rigenerazione della cache ottimizzata..."
php artisan route:cache
php artisan view:cache

