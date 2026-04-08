# základní docker obraz s PHP a Apache
FROM php:8-apache

# aktualizace systému
RUN apt update && apt upgrade -y

# instalace rozšíření pro XSL procesor
RUN apt install -y libxslt1-dev
RUN docker-php-ext-install xsl

# nástroje
RUN apt install -y mc vim nano

# data, Apache (www-data) smí číst i psát
RUN mkdir -p /var/mixolog/drinks
RUN chown -R www-data /var/mixolog
