FROM php:7.4-cli-alpine
RUN curl -sS https://getcomposer.org/installer | php
WORKDIR /usr/src/php-libraries