<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

try {
    $utilisateur = utilisateurConnecte();

    echo json_encode([
        'success' => true,
        'authenticated' => $utilisateur !== null,
        'user' => $utilisateur ? [
            'id_utilisateur' => (int) $utilisateur['id_utilisateur'],
            'pseudo' => $utilisateur['pseudo'],
            'role_plateforme' => $utilisateur['role_plateforme']
        ] : null,
        'csrf' => $_SESSION['csrf']
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $exception) {
    error_log('API session : ' . $exception->getMessage());

    http_response_code(503);

    echo json_encode([
        'success' => false,
        'authenticated' => false,
        'user' => null,
        'message' => 'Service indisponible.'
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
