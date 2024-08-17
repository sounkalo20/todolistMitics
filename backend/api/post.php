<?php
header("Access-Control-Allow-Origin:*");
require '../connexion_bd.php'; // Inclure le fichier de connexion à la base de données

header("Content-Type: application/json"); // Spécifier le type de contenu en JSON

try {
    // Récupérer les données envoyées par le frontend
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? '';

    // Vérifier si le titre est fourni
    if (isset($title) && !empty($title)) {
        // Préparer la requête pour insérer la nouvelle tâche
        $stmt = $pdo->prepare("INSERT INTO tasks (title, description) VALUES (?, ?)");

        // Exécuter la requête
        $result = $stmt->execute([$title, $description]);

        // Vérifier si l'insertion a réussi
        if ($result === false) {
            throw new Exception('Erreur lors de l\'insertion de la tâche.');
        }

        // Envoyer une réponse JSON confirmant la création de la tâche
        echo json_encode(['message' => 'Tâche créée avec succès']);
    } else {
        throw new Exception('Le titre est obligatoire.');
    }
} catch (Exception $e) {
    // Capturer et gérer les exceptions
    http_response_code(400); // Code de réponse HTTP 400 pour requête incorrecte
    echo json_encode([
        'error' => 'Erreur de création',
        'message' => $e->getMessage() // Inclure le message d'erreur pour le débogage
    ]);
}
?>
