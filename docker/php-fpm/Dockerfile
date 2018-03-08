FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
        zlib1g-dev \
    && docker-php-ext-install zip pcntl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN useradd admin
#RUN usermod -s /bin/bash -u 1000 admin
#USER admin

COPY docker/php-fpm/entrypoint.sh /entrypoint.sh
RUN chmod 755 /entrypoint.sh

WORKDIR "/application"

ENTRYPOINT ["/entrypoint.sh"]
