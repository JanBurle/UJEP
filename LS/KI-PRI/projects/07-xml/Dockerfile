FROM php:8-apache

RUN apt update && apt upgrade -y
RUN apt install -y mc vim nano less

# XSL processor extension
RUN apt install -y libxslt1-dev
RUN docker-php-ext-install xsl

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
