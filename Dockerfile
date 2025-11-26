FROM php:8.2-apache

# Install PHP extensions commonly required by IMathAS
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libzip-dev \
        zip \
        unzip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j"$(nproc)" \
        gd \
        mysqli \
        pdo \
        pdo_mysql \
        zip && \
    rm -rf /var/lib/apt/lists/*

# Enable Apache modules used by IMathAS
RUN a2enmod rewrite headers

# Copy application code into the container
COPY . /var/www/html

# Ensure proper permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Expose the default HTTP port
EXPOSE 80

# Start Apache in the foreground (default CMD from php:apache)

