#!/bin/bash

# Script de entrypoint para inicializar o banco e depois iniciar o Apache

# Executar script de inicialização do banco
if [ -n "$DB_HOST" ] && [ -n "$DB_USER" ] && [ -n "$DB_PASS" ]; then
    echo "Initializing database..."
    /var/www/html/init-db.sh
else
    echo "Database environment variables not set, skipping database initialization"
fi

# Iniciar Apache
echo "Starting Apache..."
exec "$@" 