<?php

//1. Connecting to a DB ^^.

/*
Dont forget the config:

sudo su - postgres -> psql

leia o script.sql;

---------------------
sudo nano ~/.bashrc

export DB_HOST=localhost
export DB_PORT=5432
export DB_NAME=calendar
export DB_USER=pcalendar
export DB_PASS=lipsum

source ~/.bashrc
*/

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}