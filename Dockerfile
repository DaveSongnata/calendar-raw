FROM php:8.1-apache

# Instalar extensão PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copiar arquivos da aplicação
COPY . /var/www/html/

# Configurar Apache
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/html

# Expor porta 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"] 