FROM php:8.2-apache

# Site config
WORKDIR /var/www/html
COPY www/ /var/www/html/
EXPOSE 80
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    a2enmod rewrite headers expires deflate && \
    echo "ServerName lrr.sh" >> /etc/apache2/apache2.conf

CMD ["apache2-foreground"]