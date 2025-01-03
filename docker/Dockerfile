FROM php:7.4-fpm-alpine

RUN apk add --no-cache \
  zip \
  libzip-dev \
  libpng-dev \
  libjpeg-turbo-dev \
  freetype-dev \
  libwebp-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
  && docker-php-ext-install gd \
  && docker-php-ext-install zip pdo pdo_mysql
