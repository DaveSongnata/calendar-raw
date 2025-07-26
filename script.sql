-- Script para criar tabela appointments
-- Versão simplificada para funcionar com PostgreSQL

-- Criar tabela appointments
CREATE TABLE IF NOT EXISTS appointments (
    id SERIAL PRIMARY KEY,
    course_name TEXT NOT NULL,
    instructor_name TEXT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    start_time TIME,
    end_time TIME
);

