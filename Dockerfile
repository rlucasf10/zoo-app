# Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# Instala extensiones necesarias para tu app
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    libpng-dev libjpeg-dev libonig-dev \
    libxml2-dev git curl \
    && docker-php-ext-install pdo pdo_mysql mbstring fileinfo

# Habilita mod_rewrite de Apache (para URLs amigables)
RUN a2enmod rewrite

# Establece el directorio de trabajo
WORKDIR /var/www/html/zoo-app

# Copia tu aplicación al directorio raíz del servidor Apache
COPY . /var/www/html/zoo-app

# INICIO DE LAS NUEVAS LÍNEAS DE CONFIGURACIÓN DE APACHE
# Elimina la configuración por defecto de Apache
RUN rm /etc/apache2/sites-enabled/000-default.conf
# Copia tu propia configuración de VirtualHost al directorio de sitios disponibles
COPY apache-zoo-app.conf /etc/apache2/sites-available/apache-zoo-app.conf
# Habilita tu nueva configuración (crea un enlace simbólico a sites-enabled)
RUN a2ensite apache-zoo-app.conf
# FIN DE LAS NUEVAS LÍNEAS DE CONFIGURACIÓN DE APACHE

# Copia Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependencias PHP (si usas Composer)
RUN [ -f composer.json ] && composer install || echo "No composer.json"

# Da permisos adecuados a los archivos
RUN chown -R www-data:www-data /var/www/html/zoo-app \
    && chmod -R 755 /var/www/html/zoo-app

# Expón el puerto 80
EXPOSE 80
