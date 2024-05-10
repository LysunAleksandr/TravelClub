FROM composer:2.1 as composer
FROM git.crtweb.ru:4567/creative/auto-deploy/images/php:8.1-symfony as php

RUN set -xe && apk update && apk upgrade

RUN apk add --no-cache \
    shadow \
    bash \
    curl


FROM php as php-debug

RUN set -eux; \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS; \
    pecl install xdebug-3.1.6; \
    docker-php-ext-enable xdebug; \
    docker-php-ext-install bcmath; \
    apk del --no-network .build-deps


FROM php-debug as dev

WORKDIR /var/www/app

ARG UID
ARG GID
ENV TARGET_UID ${UID:-1000}
ENV TARGET_GID ${GID:-1000}

RUN usermod -u ${TARGET_UID} www-data && groupmod -g ${TARGET_GID} www-data
RUN mkdir -p /var/www/app && chown -R www-data:www-data /var/www/app

FROM php-debug as stage

COPY ./app/composer.json /var/www/app/composer.json
COPY ./app/composer.lock /var/www/app/composer.lock

COPY ./app /var/www/app
