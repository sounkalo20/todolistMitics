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
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Récupérer l'identifiant de la tâche à partir de l'URL
        parse_str(file_get_contents("php://input"), $data);
        $id = $_GET['id'] ?? null;

        if (empty($id)) {
            throw new Exception('L\'identifiant est obligatoire.');
        }

        // Préparer la requête pour supprimer la tâche avec l'identifiant donné
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $result = $stmt->execute([$id]);

        // Vérifier si la suppression a réussi
        if ($result === false || $stmt->rowCount() === 0) {
            throw new Exception('La tâche spécifiée n\'existe pas ou n\'a pas pu être supprimée.');
        }

        // Envoyer une réponse JSON confirmant la suppression de la tâche
        echo json_encode(['message' => 'Tâche supprimée avec succès']);
    } else {
        throw new Exception('Méthode non autorisée.');
    }

} catch (Exception $e) {
    // Capturer et gérer les exceptions
    http_response_code(400); // Code de réponse HTTP 400 pour requête incorrecte
    echo json_encode([
        'error' => 'Erreur de suppression',
        'message' => $e->getMessage() // Inclure le message d'erreur pour le débogage
    ]);
}
?>
