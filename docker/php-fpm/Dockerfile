FROM php:7.1-fpm

RUN useradd admin
RUN usermod -s /bin/bash -u 1000 admin
USER admin

WORKDIR "/application"
