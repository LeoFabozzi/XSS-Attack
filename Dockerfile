# Utilizza un'immagine PHP con Apache
FROM php:8.0-apache

# Installa estensioni necessarie (mysqli, ecc.)
RUN docker-php-ext-install mysqli
