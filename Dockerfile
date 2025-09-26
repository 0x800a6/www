FROM php:8.2-apache
WORKDIR /var/www/html
COPY www/ /var/www/html/
EXPOSE 80
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    a2enmod rewrite headers expires deflate

CMD ["apache2-foreground"]