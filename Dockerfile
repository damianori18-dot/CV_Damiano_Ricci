FROM node:22-alpine AS frontend

WORKDIR /var/www/html

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

FROM php:8.4-apache

# Installa le estensioni PHP necessarie per Laravel e MySQL
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

RUN printf 'upload_max_filesize=8M\npost_max_size=10M\n' > /usr/local/etc/php/conf.d/uploads.ini

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Imposta la cartella di lavoro
WORKDIR /var/www/html

# Copia i file nel container
COPY . .

# Installa le dipendenze di Composer
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
COPY --from=frontend /var/www/html/public/build /var/www/html/public/build

# Forza i permessi corretti prima dell'avvio usando l'utente root
USER root
RUN mkdir -p /var/www/html/storage/logs /var/www/html/storage/framework/sessions /var/www/html/storage/framework/views /var/www/html/storage/framework/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# Cambia il DocumentRoot di Apache sulla cartella public di Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Comando di avvio che esegue lo script e avvia Apache
CMD ["sh", "-c", ". ./scripts/deploy.sh && exec apache2-foreground"]
