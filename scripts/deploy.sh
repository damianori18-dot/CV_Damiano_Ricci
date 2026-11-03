#!/usr/bin/env bash
set -e

echo "Configurazione permessi cartelle storage..."
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "Pulizia della cache di configurazione..."
php artisan config:clear

if [ -n "${MYSQL_ATTR_SSL_CA:-}" ]; then
    if [ ! -r "$MYSQL_ATTR_SSL_CA" ]; then
        echo "MySQL CA certificate is missing or unreadable at the configured path." >&2
        exit 1
    fi

    php -r '
        $certificate = file_get_contents($argv[1]);
        if ($certificate === false || openssl_x509_read($certificate) === false) {
            fwrite(STDERR, "MySQL CA certificate is not a valid PEM certificate.\n");
            exit(1);
        }

        echo "MySQL CA certificate is readable and valid.\n";
    ' "$MYSQL_ATTR_SSL_CA"
fi

echo "Esecuzione delle migrazioni del database..."
php artisan migrate --force

echo "Pulizia delle cache applicative..."
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "Rigenerazione della cache ottimizzata..."
php artisan route:cache
php artisan view:cache
