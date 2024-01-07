# get php:apache image
FROM php:8.0.25-apache  

# install mysqli extension for php
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy the contents of the src directory into the /var/www/html directory of the image
COPY . /var/www/html/

# No need to explicitly restart the service; it will be done when the container starts
