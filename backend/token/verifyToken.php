<?php

// Définir un token robuste et le hacher
$rawToken = 'aB3$eT1*Xz7&';
$hashedToken = password_hash($rawToken, PASSWORD_BCRYPT);

// Fonction de vérification du token
function verifyToken($token)
{
    global $hashedToken;

    // Vérifier si le token est présent
    if (empty($token)) {
        throw new Exception('Token is missing');
    }

    // Vérifier si le token correspond au token haché
    if (!password_verify($token, $hashedToken)) {
        throw new Exception('Invalid token');
    }
}
