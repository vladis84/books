FROM php:8.4-fpm

# make sure apt is up to date
RUN apt-get update --fix-missing
RUN apt-get update \
    && apt-get -y install curl build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev libicu-dev \
    libmagickwand-dev libzip-dev zip git locales

# Locale
RUN sed -i -e \
  's/# ru_RU.UTF-8 UTF-8/ru_RU.UTF-8 UTF-8/' /etc/locale.gen \
   && locale-gen

ENV LANG ru_RU.UTF-8
ENV LANGUAGE ru_RU:ru
ENV LC_LANG ru_RU.UTF-8
ENV LC_ALL ru_RU.UTF-8

RUN docker-php-ext-install gd pdo pdo_mysql mysqli zip intl sysvshm posix sysvsem exif bcmath sockets
RUN docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install -j$(nproc) gd

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY my.ini $PHP_INI_DIR/conf.d/x-my.ini

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY ./start.sh /start.sh

RUN apt-get autoclean && rm -r /var/lib/apt/lists/*

# Add user from .env file
ARG UID
ARG GID
ARG UNAME
RUN usermod -u ${UID} www-data
