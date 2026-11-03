FROM php:8.2-apache

# 1. Installa le estensioni PHP necessarie per Laravel e MySQL
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && a2enmod rewrite

# 2. Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Copia i file del progetto dentro il server Apache
WORKDIR /var/www/html
COPY . .

# 4. Imposta i permessi corretti per Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 5. Modifica la configurazione di Apache per puntare alla cartella /public di Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 6. Avvia lo script di deploy che abbiamo creato prima e poi avvia Apache
CMD ["sh", "-c", "./scripts/deploy.sh && apache2-foreground"]
