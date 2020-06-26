FROM php:7.2-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf

RUN apt update && apt upgrade -y \
  && apt install -y git zlib1g-dev libicu-dev g++ \
  && docker-php-ext-configure intl \
  && docker-php-ext-install pdo pdo_mysql mysqli zip intl \
  && a2enmod rewrite \
  && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer \
  && composer development-enable

EXPOSE 80
