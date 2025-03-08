# Use an official PHP runtime as a parent image
FROM php:8.2-apache

# Install required system packages and dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Install PHP extensions and enable them
RUN docker-php-ext-install pdo_pgsql

# Copy custom Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite

# Install PHP dependencies (composer)
RUN composer install

# Expose port 80 to allow incoming connections to the container
EXPOSE 80
