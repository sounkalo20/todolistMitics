<?php
header("Access-Control-Allow-Origin:*"); 
require '../connexion_bd.php'; // Inclure le fichier de connexion à la base de données


try {
    // Exécuter la requête pour récupérer toutes les tâches
    $stmt = $pdo->query("SELECT * FROM tasks");

    // Vérifier si la requête a renvoyé des résultats
    if ($stmt === false) {
        throw new Exception('Erreur lors de l\'exécution de la requête.');
    }

    // Récupérer les résultats sous forme de tableau associatif
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Envoyer les tâches au frontend sous forme de JSON
    echo json_encode($tasks);

} catch (Exception $e) {
    echo($e->getMessage());
}
?>
