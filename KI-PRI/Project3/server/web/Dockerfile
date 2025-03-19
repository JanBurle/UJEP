FROM php:8-apache

# upgrade & install tools
RUN apt update && apt upgrade -y
RUN apt install -y mc vim nano less

# XSL processor extension
RUN apt install -y libxslt1-dev
RUN docker-php-ext-install xsl

# postgres extension
RUN apt install -y libpq-dev && docker-php-ext-install pdo_pgsql

# PHP debugger
RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN cat <<EOF >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
xdebug.mode=debug
xdebug.idekey=docker
xdebug.start_with_request=yes
xdebug.client_host=host.docker.internal
xdebug.client_port=9003
EOF

# configuration
# COPY apache.conf /etc/apache2/sites-available/000-default.conf
# COPY php.ini /usr/local/etc/php/
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN a2enmod headers rewrite

# working directory
WORKDIR /var/www

