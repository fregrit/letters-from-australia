# Dockerfile
FROM php:apache

# Install dependencies
RUN apt-get update && apt-get install -y \
  git \
  libbrotli-dev

# Enable mod_rewrite, mod_deflate, and mod_brotli
RUN a2enmod rewrite
RUN a2enmod deflate
RUN a2enmod brotli

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the entire project
COPY . /app

# Set working directory
WORKDIR /app

# Copy custom Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Create logs directory and set permissions
RUN mkdir -p /app/logs && chmod -R 755 /app/logs

# Set permissions for the www directory
RUN chown -R www-data:www-data /app/www && chmod -R 755 /app/www

# Copy php.ini
COPY php.ini /usr/local/etc/php/

# Enable the site configuration
RUN a2ensite 000-default.conf

# Install Composer dependencies
RUN composer install

# Start Apache
CMD ["apache2-foreground"]
