FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
# Tools
    apt-utils \
    wget \
    git \
    nano \
    iputils-ping \
    locales \
    unzip \
    zip \
    xz-utils \
    vim \
    libaio1 \
    libaio-dev \
    build-essential \
    libzip-dev \
    supervisor \
# Configure PHP
    libxml2-dev \
    libmcrypt-dev \
    libpng-dev
RUN docker-php-ext-configure gd && \
    docker-php-ext-install -j$(nproc) mysqli soap gd zip opcache pdo pdo_mysql

# Configure Apache & clean
RUN a2enmod rewrite && \
    apt-get clean && \
    apt-get -y purge \
        libxml2-dev \
        libmcrypt-dev \
        libpng12-dev && \
    rm -rf /var/lib/apt/lists/* /usr/src/*
# ======= composer =======
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Set locales
RUN locale-gen en_US.UTF-8 en_GB.UTF-8 de_DE.UTF-8 es_ES.UTF-8 fr_FR.UTF-8 it_IT.UTF-8 km_KH sv_SE.UTF-8 fi_FI.UTF-8
# get the tar.xz from php... this is mostly for oracle
RUN wget -O /usr/src/php.tar.xz https://www.php.net/distributions/php-7.2.21.tar.xz
#create the containers php.ini
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
    sed -i -e "s/^ *memory_limit.*/memory_limit = 4G/g" /usr/local/etc/php/php.ini
# get code sniffer
RUN composer global require "squizlabs/php_codesniffer=*"
# get xdebug and configure
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# the url for fetching base data
#https://openpaymentsdata.cms.gov/api/views/p2ve-2ws5/rows.csv?accessType=DOWNLOAD

# get nodejs
RUN curl -sL https://deb.nodesource.com/setup_13.x | bash -

# apt-get update and needed packages
RUN apt-get update && apt-get install -qqy git unzip \
        libpng-dev \
        default-mysql-client \
        nodejs \
        libaio1 wget && apt-get clean autoclean && apt-get autoremove --yes &&  rm -rf /var/lib/{apt,dpkg,cache,log}/

# RUN apt-get update && apt-get install -qqy npm && apt-get clean autoclean && apt-get autoremove --yes &&  rm -rf /var/lib/{apt,dpkg,cache,log}/

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# get php code sniffer
RUN wget -O /tmp/phpcs.phar https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
RUN cp /tmp/phpcs.phar /usr/local/bin/phpcs
RUN chmod +x /usr/local/bin/phpcs

# set phpcs config
RUN /usr/local/bin/phpcs --config-set show_progress 1 && \
    /usr/local/bin/phpcs --config-set colors 1 && \
    /usr/local/bin/phpcs --config-set report_width 140 && \
    /usr/local/bin/phpcs --config-set encoding utf-8

# get php code beautifier
RUN wget -O /tmp/phpcbf.phar https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar
RUN cp /tmp/phpcbf.phar /usr/local/bin/phpcbf
RUN chmod +x /usr/local/bin/phpcbf

# ======= composer =======
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#  Configuring Apache
COPY dock-files/apache/apache2.conf /etc/apache2/apache2.conf

RUN  rm /etc/apache2/sites-available/000-default.conf

# Enable rewrite module
RUN a2enmod rewrite

WORKDIR /var/www/html

#create the containers php.ini
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
    sed -i -e "s/^ *memory_limit.*/memory_limit = 4G/g" /usr/local/etc/php/php.ini

COPY ./dock-files/startup.sh /var/startup.sh
