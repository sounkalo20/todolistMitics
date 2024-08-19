<?php
// db.php - Fichier de connexion à la base de données

// Informations de connexion
$host = 'localhost';
$db = 'todolist_db';
$user = 'root';
$pass = '';

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Configuration pour lever des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur, afficher un message et arrêter le script
    die("Erreur de connexion : " . $e->getMessage());
}
?>
