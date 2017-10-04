FROM php:7.0-apache

EXPOSE 80

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure zip --enable-zip \
    && docker-php-ext-install zip

RUN apt update && \
    apt install -y nano

RUN mkdir -p SC13-QRC-generator/tmp

WORKDIR SC13-QRC-generator/

COPY . .

RUN chmod -R 777 .





