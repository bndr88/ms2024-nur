FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install sockets zip pdo pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear directorio de trabajo
WORKDIR /app

# Copiar archivos del consumidor
COPY . /app

# Instalar dependencias con Composer
RUN composer install

# Asegurar que el autoload esté actualizado
RUN composer dump-autoload

# Ejecutar el consumidor por defecto
CMD ["php", "publish.php"]
