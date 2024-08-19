<?php
require '../connexion_bd.php';
require '../token/verifyToken.php';

header("Access-Control-Allow-Origin: *"); // Autoriser les requêtes depuis n'importe quelle origine
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Autoriser les méthodes HTTP spécifiques
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Autoriser les en-têtes spécifiques

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    // Lire les données JSON du corps de la requête
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['token']) || !isset($data['id'])) {
        throw new Exception('Token or ID is missing');
    }

    // Vérifier le token
    verifyToken($data['token']);

    // Récupérer l'ID de la tâche
    $id = $data['id'];

    // Préparer la requête SQL pour récupérer les détails de la tâche
    $stmt = $pdo->prepare("SELECT title, description, completed FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($task === false) {
        throw new Exception('La tâche spécifiée n\'existe pas.');
    }

    // Mettre à jour les champs uniquement si de nouvelles valeurs sont fournies
    $title = isset($data['title']) ? $data['title'] : $task['title'];
    $description = isset($data['description']) ? $data['description'] : $task['description'];
    $completed = isset($data['completed']) ? (int)$data['completed'] : $task['completed'];

    // Préparer la requête SQL pour mettre à jour la tâche
    $stmt = $pdo->prepare("UPDATE tasks SET title = :title, description = :description, completed = :completed WHERE id = :id");

    // Lier les paramètres
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':completed', $completed, PDO::PARAM_INT); // Assurer que completed est un entier
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Assurer que id est un entier

    // Exécuter la requête
    if ($stmt->execute() === false) {
        throw new Exception('Erreur lors de la mise à jour de la tâche.');
    }

    // Répondre avec un message de succès
    echo json_encode(['message' => 'Tâche mise à jour avec succès']);
} catch (Exception $e) {
    // Répondre avec une erreur
    http_response_code(400);
    echo json_encode([
        'error' => 'Erreur lors de la mise à jour de la tâche',
        'message' => $e->getMessage()
    ]);
}
