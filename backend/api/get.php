<?php
require '../connexion_bd.php';
require '../token/verifyToken.php';

header("Access-Control-Allow-Origin: *"); // Autoriser les requêtes depuis n'importe quelle origine
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Autoriser les méthodes HTTP spécifiques
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Autoriser les en-têtes spécifiques

// Gérer les requêtes OPTIONS pour les pré-demandes CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); 
    exit; 
}

try {
    // Lire les données JSON envoyées dans le corps de la requête
    $data = json_decode(file_get_contents("php://input"), true);

    // Vérifier que le token est présent dans les données
    if (!isset($data['token'])) {
        throw new Exception('Token is missing');
    }

    // Vérifier la validité du token
    verifyToken($data['token']);

    $stmt = $pdo->query("SELECT * FROM tasks");

    // Vérifier si la requête a échoué
    if ($stmt === false) {
        throw new Exception('Erreur lors de l\'exécution de la requête.'); 
    }

    // Récupérer toutes les tâches sous forme de tableau associatif
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Répondre avec les tâches au format JSON
    echo json_encode($tasks);

} catch (Exception $e) {
    // Répondre avec un code d'erreur 400 et un message en cas d'exception
    http_response_code(400); 
    echo json_encode([
        'error' => 'Erreur lors de la récupération des tâches', 
        'message' => $e->getMessage()
    ]);
}
?>
