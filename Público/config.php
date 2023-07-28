<?php
// Configurações do banco de dados
define('DB_HOST', 'db');
define('DB_PORT', '3306');
define('DB_NAME', 'employees');
define('DB_USER', 'root');
define('DB_PASS', 'root');

// Conexão com o banco de dados
try {
    $db = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro ao conectar com o banco de dados: ' . $e->getMessage());
}
