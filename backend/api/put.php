<?php
require '../connexion_bd.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Lire les paramètres d'URL
        parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $queryParams);
        $id = $queryParams['id'] ?? null;

        // Lire le corps de la requête pour les données JSON
        $data = json_decode(file_get_contents("php://input"), true);

        $title = $data['title'] ?? null;
        $description = $data['description'] ?? null;
        $completed = isset($data['completed']) ? (int)$data['completed'] : 0;

        if (empty($id) || !is_numeric($id) || empty($title)) {
            throw new Exception('Un identifiant valide et un titre sont obligatoires.');
        }

        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, completed = ? WHERE id = ?");
        $result = $stmt->execute([$title, $description, $completed, $id]);

        if ($result === false || $stmt->rowCount() === 0) {
            throw new Exception('La tâche spécifiée n\'existe pas ou n\'a pas pu être mise à jour.');
        }

        http_response_code(200);
        echo json_encode(['message' => 'Tâche mise à jour avec succès']);
    } else {
        throw new Exception('Méthode non autorisée.');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Erreur de mise à jour',
        'message' => $e->getMessage()
    ]);
}
