FROM php:8.1-apache

# Update system
RUN apt-get update && apt-get upgrade -y

# Global requirement
RUN apt-get install -y nano wget git gcc make autoconf

# Node JS install
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash
RUN apt-get install -y nodejs

# Composer install
COPY --from=composer:2.4 /usr/bin/composer /usr/local/bin/composer

# Symfony CLI install
RUN cd /root \ 
    && wget https://github.com/symfony-cli/symfony-cli/releases/download/v5.4.17/symfony-cli_linux_amd64.tar.gz \
    && tar -xf symfony-cli_linux_amd64.tar.gz \
    && mv /root/symfony /usr/local/bin/symfony

# Set PHP ini to dev default
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# ionCube install
RUN curl -o ioncube.tar.gz https://downloads.ioncube.com/loader_downloads/ioncube_loaders_lin_x86-64.tar.gz \
    && tar -xvvzf ioncube.tar.gz \
    && mv ioncube/ioncube_loader_lin_8.1.so `php-config --extension-dir` \
    && rm -Rf ioncube.tar.gz ioncube \
    && docker-php-ext-enable ioncube_loader_lin_8.1

# MySQL install
RUN docker-php-ext-install -j$(nproc) mysqli
RUN docker-php-ext-install -j$(nproc) pdo_mysql

# OPcache install
RUN docker-php-ext-install -j$(nproc) opcache

# intl install
RUN apt-get install -y libicu-dev
RUN docker-php-ext-install -j$(nproc) intl

# XDebug install
RUN pecl install xdebug && docker-php-ext-enable xdebug

# yaml install
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libc-dev pkg-config libyaml-dev
RUN pecl install yaml && docker-php-ext-enable yaml

# zip install
RUN apt-get install -y libzip-dev unzip
RUN pecl install zip && docker-php-ext-enable zip

# APCu install
RUN pecl install apcu && docker-php-ext-enable apcu

# Clean up
RUN apt autoremove

# Apache setup
RUN a2enmod rewrite

RUN a2dissite 000-default.conf

COPY ./000-public.conf /etc/apache2/sites-available/000-public.conf

RUN a2ensite 000-public.conf

RUN echo 'alias sc="php bin/console"' >> /etc/bash.bashrcphp

WORKDIR /var/www/html
