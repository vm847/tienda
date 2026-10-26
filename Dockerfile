# Imagen para desarrollar Laravel: PHP 8.4 + Apache + extensiones + Composer
FROM php:8.4.27-apache

# Paquetes del sistema y extensiones de PHP que usa Laravel
RUN apt-get update && apt-get install -y git unzip libzip-dev \
 && docker-php-ext-install pdo_mysql zip \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

# Apache tiene que servir la carpeta public/ de Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Composer, para usarlo dentro del contenedor
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_HOME=/tmp/composer

# El código NO se copia: entra por el volumen de compose.yaml (cambios al instante)
WORKDIR /var/www/html
EXPOSE 80
