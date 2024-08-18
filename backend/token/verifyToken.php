<?php

// Définir un token robuste et le hacher
$rawToken = 'djessyaroma1234567';
$hashedToken = password_hash($rawToken, PASSWORD_BCRYPT);

// Fonction de vérification du token
function verifyToken($headers)
{
    global $hashedToken;

    // Vérifier si le token est présent dans les en-têtes
    if (!isset($headers['Authorization'])) {
        throw new Exception('Authorization header missing');
    }

    $token = $headers['Authorization'];

    // Vérifier si le token correspond au token haché
    if (!password_verify($token, $hashedToken)) {
        throw new Exception('Invalid token');
    }
}

// Fonction pour récupérer les en-têtes de la requête
function getRequestHeaders()
{
    $headers = [];
    foreach ($_SERVER as $key => $value) {
        if (substr($key, 0, 5) === 'HTTP_') {
            $header = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
            $headers[$header] = $value;
        }
    }
    return $headers;
}
