# Use the base image with PHP 8.1
FROM php:8.1-fpm

# Set the working directory
WORKDIR /var/www/html

# Copy the contents of the local directory to the working directory in the container
COPY . .

# Expose port 8080
EXPOSE 8080

# Start the PHP server
CMD ["php", "-S", "0.0.0.0:8080"]

