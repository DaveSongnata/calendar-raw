FROM php:8.1-apache

# Instalar extensão PostgreSQL e cliente PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copiar arquivos da aplicação
COPY . /var/www/html/

# Configurar Apache
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www/html

# Tornar o script executável
RUN chmod +x /var/www/html/init-db.sh

# Expor porta 80
EXPOSE 80

# Script de inicialização
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"] 