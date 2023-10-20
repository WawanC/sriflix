#!/bin/sh

# migrate database
php artisan migrate:refresh --force --seed

# update application cache
php artisan optimize

# start the application

php-fpm -D &&  nginx -g "daemon off;"
