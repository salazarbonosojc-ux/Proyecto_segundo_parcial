FROM php:8.2-apache

# Instalar y habilitar el driver PDO MySQL requerido para la base de datos
RUN docker-php-ext-install pdo pdo_mysql

# Copiar los archivos del proyecto al directorio de trabajo del contenedor
COPY . /var/www/html/

# Exponer el puerto estándar HTTP
EXPOSE 80
