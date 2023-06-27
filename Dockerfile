FROM php:7.3-apache
RUN apt-get update && apt-get install -y libxml2-dev libzip-dev
RUN docker-php-ext-install soap mysqli pdo_mysql zip
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
