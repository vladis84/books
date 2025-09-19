#!/bin/bash

cd /var/www/books/www && composer install

php-fpm
