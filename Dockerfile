# Imagen base oficial con PHP + Apache
FROM php:8.2-apache

# Dependencias para el driver de MongoDB
RUN apt-get update && apt-get install -y libssl-dev pkg-config \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Si usas MySQL también, puedes dejar esto:
# RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar tu proyecto al documento raíz de Apache
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
