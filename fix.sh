#!/bin/bash

docker-compose run --rm php-libraries vendor/bin/php-cs-fixer fix src-php
docker-compose run --rm php-libraries vendor/bin/php-cs-fixer fix tests-php