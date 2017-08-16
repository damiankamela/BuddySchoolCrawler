FROM php:7.1-fpm


RUN apt-get update && apt-get install -y \
        libmagickwand-dev \
        libmemcached-dev zlib1g-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libxslt-dev \
        libxml2-dev \
        zlib1g-dev \
        libyaml-dev \
        libicu-dev g++ \
    && docker-php-ext-install -j$(nproc) iconv mcrypt intl pdo_mysql bcmath bz2 mbstring xsl \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install zip

RUN pecl install memcached-3.0.3 \
    && pecl install redis-3.1.2 \
    && pecl install yaml-2.0.0 \
    && pecl install xdebug-2.5.5 \
    && pecl install imagick-3.4.3 \
    && docker-php-ext-enable memcached redis xdebug imagick yaml

RUN useradd owadmin
RUN usermod -s /bin/bash -u 1000 owadmin
USER owadmin

WORKDIR "/application"
