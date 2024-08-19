<?php
require '../connexion_bd.php';
require '../token/verifyToken.php';

// Définir les en-têtes HTTP pour permettre les requêtes cross-origin et spécifier les méthodes et en-têtes autorisés
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Si la requête est une demande OPTIONS (pré-vol pour CORS), répondre avec un code 200 et sortir
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    // Lire les données JSON envoyées dans le corps de la requête
    $data = json_decode(file_get_contents("php://input"), true);

    // Vérifier si le token est présent dans les données de la requête
    if (!isset($data['token'])) {
        throw new Exception('Token is missing'); // Lever une exception si le token est manquant
    }

    // Vérifier la validité du token
    verifyToken($data['token']);

    // Préparer la requête SQL pour insérer une nouvelle tâche dans la base de données
    $stmt = $pdo->prepare("INSERT INTO tasks (title, description) VALUES (:title, :description");

    // Lier les paramètres de la requête aux valeurs fournies dans le corps de la requête
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':description', $data['description']);

    // Exécuter la requête SQL pour insérer les données dans la base de données
    if ($stmt->execute() === false) {
        throw new Exception('Erreur lors de la création de la tâche.'); // Lever une exception si l'exécution échoue
    }

    // Répondre avec un message de succès si la tâche a été créée avec succès
    echo json_encode(['message' => 'Tâche créée avec succès']);

} catch (Exception $e) {
    // En cas d'erreur, répondre avec un code 400 et fournir un message d'erreur
    http_response_code(400);
    echo json_encode([
        'error' => 'Erreur lors de la création de la tâche',
        'message' => $e->getMessage()
    ]);
}
?>
