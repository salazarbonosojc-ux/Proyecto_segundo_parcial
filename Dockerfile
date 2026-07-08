FROM php:8.2-apache

# Cambiar el DocumentRoot de Apache a la carpeta /public para mayor seguridad y URL limpia
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Instalar y habilitar el driver PDO MySQL requerido para la base de datos
RUN docker-php-ext-install pdo_mysql

# Copiar los archivos del proyecto al directorio de trabajo del contenedor
COPY . /var/www/html/

# Exponer el puerto estándar HTTP
EXPOSE 80
