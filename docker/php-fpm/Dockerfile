FROM php:8.1-fpm-alpine

RUN apk add --no-cache nodejs npm yarn \
    && npm install -g npm@latest

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

WORKDIR /app
