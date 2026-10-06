<?php
$host = 'localhost';
$port = '5432';
$user = 'sio_user';
$password = getenv('SIO_DB_PASSWORD') ?: 'codegode';
$database = 'sio_tournament';

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$database",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
    $pdo->exec("SET client_encoding TO 'UTF8'");
} catch (PDOException $e) {
    error_log('Connexion PostgreSQL : ' . $e->getMessage());
    http_response_code(503);
    exit('Connexion à la base impossible. Vérifie les paramètres de connexion.php.');
}
