FROM php:7.2-apache
MAINTAINER {m.rey00, ulisesrcolina}@gmail.com
ADD *.php /var/www/html/
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli
RUN apachectl restart
