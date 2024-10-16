# Use a specific tag for the base image to ensure stability
FROM laravelfans/laravel:9

# Set environment variables
ENV COMPOSER_ALLOW_SUPERUSER=1

# Update the package list and install dependencies
RUN apt-get update && apt-get install -y vim curl

# Add NodeSource repository and install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

# Install PHP extensions using the provided installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions imagick

# Setup the working directory
WORKDIR /var/www/

# Copy the application code to the working directory
COPY . /var/www/

# Install PHP dependencies without scripts and ignoring some platform requirements
RUN composer install --no-scripts --ignore-platform-req=ext-exif --ignore-platform-req=ext-bcmath

# Expose the port Laravel serves on
EXPOSE 6001 8000 5173

# Here you might want to run your application, uncomment and modify the following line:
#CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
