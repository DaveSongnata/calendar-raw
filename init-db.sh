#!/bin/bash

# Script para inicializar o banco de dados
# Versão robusta para Render e outras plataformas

echo "Waiting for PostgreSQL to be ready..."

# Aguardar PostgreSQL ficar disponível
for i in {1..30}; do
    if pg_isready -h $DB_HOST -p $DB_PORT -U $DB_USER -d $DB_NAME > /dev/null 2>&1; then
        echo "PostgreSQL is ready!"
        break
    fi
    echo "Waiting for PostgreSQL... ($i/30)"
    sleep 2
done

# Verificar se conseguiu conectar
if ! pg_isready -h $DB_HOST -p $DB_PORT -U $DB_USER -d $DB_NAME > /dev/null 2>&1; then
    echo "ERROR: Could not connect to PostgreSQL"
    exit 1
fi

# Executar script SQL
echo "Creating database tables..."
PGPASSWORD=$DB_PASS psql -h $DB_HOST -p $DB_PORT -U $DB_USER -d $DB_NAME -f /var/www/html/script.sql

if [ $? -eq 0 ]; then
    echo "Database initialized successfully!"
else
    echo "ERROR: Failed to initialize database"
    exit 1
fi 