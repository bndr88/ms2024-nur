FROM php:8.3-apache

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Habilitar módulos de Apache necesarios
RUN a2enmod rewrite

# Configurar Apache para usar /var/www/html/src/Presentacion como DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/src/Presentacion|' /etc/apache2/sites-available/000-default.conf

# Copiar archivos de la aplicación antes de instalar dependencias
COPY . /var/www/html/

# Establecer permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Instalar extensiones y dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Instalar Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala sockets y otras extensiones necesarias
RUN docker-php-ext-install sockets

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# RUN composer require phpseclib/phpseclib:^3.0 -W

# Exponer el puerto de Apache
EXPOSE 80

# Comando por defecto para iniciar Apache
CMD ["apache2-foreground"]
