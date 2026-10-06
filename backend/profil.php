<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

try {
    $utilisateur = utilisateurConnecte();

    if (!$utilisateur) {
        http_response_code(401);

        echo json_encode([
            'success' => false,
            'message' => 'Authentification requise.'
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        exit;
    }

    echo json_encode([
        'success' => true,
        'user' => [
            'id_utilisateur' => (int) $utilisateur['id_utilisateur'],
            'nom' => $utilisateur['nom'],
            'prenom' => $utilisateur['prenom'],
            'pseudo' => $utilisateur['pseudo'],
            'email' => $utilisateur['email'],
            'role_plateforme' => $utilisateur['role_plateforme'],
            'etablissement' => $utilisateur['etablissement'],
            'option_sio' => $utilisateur['option_sio']
        ]
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $exception) {
    error_log('API profil : ' . $exception->getMessage());

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Une erreur interne est survenue.'
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
