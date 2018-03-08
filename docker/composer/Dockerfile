FROM composer:latest

RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add shadow

RUN mkdir -p /composer
RUN chmod -R 777 /composer

RUN useradd admin
RUN usermod -s /bin/bash -u 1000 admin

USER admin

WORKDIR /app

CMD ["install", "--prefer-source", "--no-interaction"]
