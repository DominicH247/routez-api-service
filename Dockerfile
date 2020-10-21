FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libpq-dev zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
  && pecl install apcu \
  && docker-php-ext-install pdo pdo_pgsql \
  && docker-php-ext-enable apcu \
  && docker-php-ext-configure zip \
  && docker-php-ext-install zip

WORKDIR /var/www/project

COPY ./app .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
RUN composer install
