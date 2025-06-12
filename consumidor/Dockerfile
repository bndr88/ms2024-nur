FROM php:8.3-cli

# Habilitar paquetes necesarios para instalar zip, git, unzip, etc.
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    && docker-php-ext-install sockets zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear directorio de trabajo
WORKDIR /app

# Copiar archivos del consumidor
COPY . /app

# Instalar dependencias con Composer
RUN composer install

# Ejecutar el consumidor por defecto
CMD ["php", "consumer_paciente.php"]


