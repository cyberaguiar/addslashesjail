FROM php:7.4-apache

RUN docker-php-ext-install mysqli

COPY index.php /var/www/html/
COPY fixed.php /var/www/html/
