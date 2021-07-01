# Build base image
FROM composer:latest as composer
FROM php:7.3-cli-alpine

# Copy composer (https://hub.docker.com/_/composer)
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /usr/src/php-libraries