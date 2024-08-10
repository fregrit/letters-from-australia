# Dockerfile
FROM php:apache

# Install dependencies
RUN apt-get update && apt-get install -y \
  git

# Enable mod_rewrite
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the entire project
COPY . /var/www

# Set permissions for build-scripts
RUN chmod -R +x /var/www/build-scripts

# Set working directory
WORKDIR /var/www

# Copy custom Apache configuration
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Create logs directory and set permissions
RUN mkdir -p /var/www/logs && chmod -R 755 /var/www/logs

# Set permissions for the www directory
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Copy translations.json and set permissions
COPY data/translations.json /var/www/data/translations.json
RUN chmod 644 /var/www/data/translations.json

# Copy php.ini
COPY php.ini /usr/local/etc/php/

# Enable the site configuration
RUN a2ensite 000-default.conf

# Install Composer dependencies
RUN composer install

# Start Apache
CMD ["apache2-foreground"]
