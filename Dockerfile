FROM php:7.4-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf

RUN apt update && apt upgrade -y \
  && apt install -y git zlib1g-dev libicu-dev g++ \
  && docker-php-ext-configure intl \
  && docker-php-ext-install pdo pdo_mysql mysqli intl \
  && a2enmod rewrite \
  && curl -sSo /usr/local/bin/composer https://getcomposer.org/download/1.10.17/composer.phar \
  && chmod 775 /usr/local/bin/composer \
  && pecl install xdebug \
  && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
  && echo "xdebug.default_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
  && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
  && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini \
  && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
  && echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
  && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
  && echo "xdebug.idekey=VSCODE" >> /usr/local/etc/php/conf.d/xdebug.ini

EXPOSE 80
