FROM php:8.5.13-fpm-alpine3.24

WORKDIR /usr/src/app/
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY security.ini "$PHP_INI_DIR/conf.d/zz-security.ini"
