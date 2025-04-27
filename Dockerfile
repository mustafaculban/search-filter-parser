# Use an official PHP runtime as a base image
FROM php:8.1-cli

# Set working directory
WORKDIR /var/www

# Install Slim requirements
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Copy the rest of the app
COPY . .

# Expose port 8080
EXPOSE 8080

# Command to run Slim API
CMD ["php", "-S", "0.0.0.0:8080", "-t", "api"]