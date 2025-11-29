FROM php:8.2-apache 
RUN apt-get update && apt-get install -y git unzip libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev libjpeg62-turbo-dev libfreetype6-dev && docker-php-ext-install pdo pdo_pgsql pdo_mysql gd zip 
RUN a2enmod rewrite 
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public 
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf 
COPY . /var/www/html 
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 
WORKDIR /var/www/html 
RUN composer install --no-dev --optimize-autoloader 
RUN chown -R www-data:www-data storage bootstrap/cache 
EXPOSE 80 
CMD ["apache2-foreground"] 
