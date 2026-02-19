# základní docker obraz s PHP a Apache
FROM php:8-apache

# aktualizace systému
RUN apt update && apt upgrade -y

# nástroje
RUN apt install -y mc vim nano less

# # PHP debugger
# RUN pecl install xdebug && docker-php-ext-enable xdebug

# RUN cat <<EOF >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
# xdebug.mode=debug
# xdebug.idekey=docker
# xdebug.start_with_request=yes
# xdebug.client_host=host.docker.internal
# xdebug.client_port=9003
# EOF

# host name
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
# enable Apache modules
RUN a2enmod rewrite headers
