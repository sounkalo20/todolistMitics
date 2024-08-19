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

    // Vérifier que le token et l'identifiant sont présents dans les données
    if (!isset($data['token']) || !isset($data['id'])) {
        throw new Exception('Token or ID is missing'); 
    }

    // Vérifier la validité du token
    verifyToken($data['token']);

    // Préparer la requête SQL pour supprimer la tâche spécifiée par l'identifiant
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->bindParam(':id', $data['id']);

    // Exécuter la requête et vérifier si l'exécution a réussi
    if ($stmt->execute() === false) {
        throw new Exception('Erreur lors de la suppression de la tâche.'); 
    }

    // Répondre avec un message de succès en cas de suppression réussie
    echo json_encode(['message' => 'Tâche supprimée avec succès']);

} catch (Exception $e) {
    // Répondre avec un code d'erreur 400 et un message en cas d'exception
    http_response_code(400);
    echo json_encode([
        'error' => 'Erreur lors de la suppression de la tâche', 
        'message' => $e->getMessage()
    ]);
}
?>
