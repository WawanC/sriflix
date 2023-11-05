FROM node:alpine AS vue
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

FROM composer:latest AS composer
WORKDIR /app

FROM php:8.2-fpm-alpine AS php
COPY --from=composer /usr/bin/composer /usr/bin/composer
USER root
WORKDIR /var/www
RUN apk update
RUN apk add curl nginx
COPY . /var/www

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pgsql pdo_pgsql

RUN composer install --no-dev --ignore-platform-reqs --prefer-dist --optimize-autoloader

COPY --from=vue /app/public/build /var/www/public/build

COPY deploy/nginx.conf /etc/nginx/nginx.conf
COPY deploy/local.ini /usr/local/etc/php/local.ini

EXPOSE 80

RUN chmod +rwx /var/www
RUN chmod -R 777 /var/www
RUN chmod +x ./deploy/post_deploy.sh

CMD [ "sh", "./deploy/post_deploy.sh" ]
