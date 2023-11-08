# Menggunakan image PHP 8.0 sebagai base image
FROM php:8.0-apache

# Install dependensi dan ekstensi PHP yang dibutuhkan untuk CodeIgniter
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip

# Install ekstensi GD dan mysqli
RUN docker-php-ext-configure gd && docker-php-ext-install gd mysqli

# # Aktifkan mod_rewrite untuk Apache
# RUN a2enmod rewrite

# # Izinkan header modul Apache
# RUN a2enmod headers

RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/ && \
    cp /etc/apache2/mods-available/headers.load /etc/apache2/mods-enabled/

# Copy kode CodeIgniter ke dalam container
COPY . /var/www/html/

# Set direktori kerja
WORKDIR /var/www/html/

# Expose port 80
EXPOSE 80

# Jalankan Apache server
CMD ["apache2-foreground"]