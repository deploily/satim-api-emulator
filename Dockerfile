
FROM php:8.2-apache

# Install PHP extensions required by Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libzip-dev libxml2-dev libicu-dev zip unzip git curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd intl

# Install system dependencies for intl and zip

# Enable Apache modules
RUN a2enmod rewrite

# Install MariaDB client
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client \ 
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Install php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Configure Apache Document Root to Laravel public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
 && sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Change Apache to listen on port 8080
RUN sed -i 's/80/8080/' /etc/apache2/ports.conf && \
    sed -i 's/:80>/:8080>/' /etc/apache2/sites-available/000-default.conf

# Configure PHP error logging to stdout/stderr
RUN ln -sf /dev/stdout /var/log/apache2/access.log \
 && ln -sf /dev/stderr /var/log/apache2/error.log \
 && echo "display_errors = On\n display_startup_errors = On\nlog_errors = On\nerror_log = /dev/stderr" > /usr/local/etc/php/conf.d/docker-php-logging.ini

# Allow .htaccess in public/
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/laravel.conf \
 && a2enconf laravel

# Set working directory
WORKDIR /var/www/html

# Copy Laravel source
COPY ./src .

# Install Composer (from official Composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV JWT_SECRET=changeme

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Give Apache/PHP write access
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 775 storage bootstrap/cache


# Expose Apache port
EXPOSE 8080

# # Optimize Laravel for production
# RUN php artisan config:cache \
#  && php artisan route:cache \
#  || true

#  # Run Apache
# CMD ["apache2-foreground"]

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]