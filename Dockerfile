FROM php:8.1-apache

# Habilitar mod_rewrite de Apache para redirecciones
RUN a2enmod rewrite

# Instalar extensión PDO MySQL para la conexión con Clever Cloud
RUN docker-php-ext-install pdo pdo_mysql

# Redirigir el DocumentRoot de Apache a la carpeta 'public' del proyecto
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar el código fuente del proyecto al contenedor
COPY . /var/www/html/

# Configurar permisos adecuados para el servidor web
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80 estándar
EXPOSE 80
