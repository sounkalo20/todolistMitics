<?php
require '../connexion_bd.php'; // Inclure le fichier de connexion à la base de données

header("Content-Type: application/json"); // Spécifier le type de contenu en JSON
header("Access-Control-Allow-Origin: *"); // Autoriser toutes les origines
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Méthodes autorisées
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // En-têtes autorisés

// Répondre aux requêtes OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    // Vérifier la méthode de la requête
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Lire le corps de la requête pour les données JSON
        $data = json_decode(file_get_contents("php://input"), true);

        // Récupérer les données envoyées par le frontend
        $id = $data['id'] ?? null;
        $title = $data['title'] ?? null;
        $description = $data['description'] ?? null;
        $completed = isset($data['completed']) ? (int)$data['completed'] : 0; // Assurez-vous que completed est un entier

        // Valider les données
        if (empty($id) || empty($title)) {
            throw new Exception('L\'identifiant et le titre sont obligatoires.');
        }

        // Préparer la requête pour mettre à jour la tâche avec les nouvelles informations
        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, completed = ? WHERE id = ?");
        $result = $stmt->execute([$title, $description, $completed, $id]);

        // Vérifier si la mise à jour a réussi
        if ($result === false || $stmt->rowCount() === 0) {
            throw new Exception('La tâche spécifiée n\'existe pas ou n\'a pas pu être mise à jour.');
        }

        // Envoyer une réponse JSON confirmant la mise à jour de la tâche
        echo json_encode(['message' => 'Tâche mise à jour avec succès']);
    } else {
        throw new Exception('Méthode non autorisée.');
    }

} catch (Exception $e) {
    // Capturer et gérer les exceptions
    http_response_code(400); // Code de réponse HTTP 400 pour requête incorrecte
    echo json_encode([
        'error' => 'Erreur de mise à jour',
        'message' => $e->getMessage() // Inclure le message d'erreur pour le débogage
    ]);
}
?>
