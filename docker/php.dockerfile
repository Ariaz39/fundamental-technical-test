FROM php:8.3-fpm

# Instala dependencias del sistema, extensiones PHP y limpia en una sola capa
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

# Copia Composer (usamos la versión oficial de Composer 2)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto Laravel al contenedor
COPY ./src /var/www/html

# Ajusta permisos y ownership para PHP-FPM (usa www-data)
RUN chmod -R 777 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html