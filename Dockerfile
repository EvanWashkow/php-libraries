# Build base image
FROM composer:latest as composer
FROM php:8.0-cli-alpine

# Copy composer (https://hub.docker.com/_/composer)
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /usr/src/php-libraries