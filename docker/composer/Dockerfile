# Composer Docker Container
FROM composer:latest

RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add shadow

RUN mkdir -p /composer
RUN chmod -R 777 /composer

RUN useradd owadmin
RUN usermod -s /bin/bash -u 1000 owadmin

USER owadmin

WORKDIR /app

CMD ["install", "--prefer-source", "--no-interaction"]
