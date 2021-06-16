#!/bin/sh

source ./composer-install.sh
docker-compose run --rm php-libraries vendor/phpunit/phpunit/phpunit --testsuite unit-test