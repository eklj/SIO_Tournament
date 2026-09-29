<?php
$host = "localhost";
$port = "5432";
$user = "postgres";
$password = "codegode";
$database = "bdd_tournoi_minecraft";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET client_encoding TO 'UTF8'");
    echo "Connexion réussie à la base de données PostgreSQL.";
}
catch (PDOException $e) {
    error_log("Erreur de connexion à la base de données PostgreSQL : " . $e->getMessage());
    echo "Erreur : " . $e->getMessage();
}