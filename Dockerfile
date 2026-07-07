FROM php:8.2-apache

# Instalar extensiones comunes de PHP si usas bases de datos (opcional pero recomendado)
RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

# Copiar todo el contenido de tu repositorio al servidor
COPY . /var/www/html/

# Cambiar la raíz de Apache para que apunte a la carpeta 'public'
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

EXPOSE 80
