<?php
require_once __DIR__ . '/auth.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
try {
    $utilisateur = utilisateurConnecte();
    echo json_encode([
        'connecte' => $utilisateur !== null,
        'utilisateur' => $utilisateur ? ['pseudo' => $utilisateur['pseudo']] : null,
        'csrf' => $_SESSION['csrf'],
    ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
} catch (Throwable $e) {
    error_log('État de session : ' . $e->getMessage());
    http_response_code(503);
    echo json_encode(['erreur' => 'Service indisponible.']);
}
