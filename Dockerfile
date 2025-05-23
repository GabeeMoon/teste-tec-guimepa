FROM php:8.0-apache

RUN docker-php-ext-install pdo pdo_mysql

# Copia todo o código para /var/www/html
COPY ./app /var/www/html/app
COPY ./public /var/www/html/public

# Configura o DocumentRoot para a pasta public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Ativa rewrite e restart apache
RUN a2enmod rewrite

WORKDIR /var/www/html/public

EXPOSE 80
