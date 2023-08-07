#!/bin/bash

set -e

git pull

php -f /usr/local/bin/composer install --no-dev --prefer-dist --no-interaction

sudo service php8.1-fpm reload

npm run migrate

Console/cake cache clear
