FROM php:8-apache

RUN apt update && apt upgrade -y
RUN apt install -y mc vim nano less

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite headers
