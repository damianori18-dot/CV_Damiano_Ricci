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

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Imposta la cartella di lavoro
WORKDIR /var/www/html

# Copia i file nel container
COPY . .

# Installa le dipendenze di Composer
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Configura i permessi per Laravel in modo approfondito
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/vendor \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Cambia il DocumentRoot di Apache sulla cartella public di Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Comando di avvio che esegue lo script e avvia Apache
CMD ["sh", "-c", "./scripts/deploy.sh && apache2-foreground"]


