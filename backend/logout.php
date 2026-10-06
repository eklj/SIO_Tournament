<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function reponseJson(array $donnees, int $statut = 200): never
{
    http_response_code($statut);

    echo json_encode(
        $donnees,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');

    reponseJson([
        'success' => false,
        'message' => 'Méthode HTTP non autorisée.'
    ], 405);
}

$csrf = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

if (!is_string($csrf) || !hash_equals($_SESSION['csrf'], $csrf)) {
    reponseJson([
        'success' => false,
        'message' => 'Jeton CSRF invalide.'
    ], 403);
}

$_SESSION = [];

$params = session_get_cookie_params();

setcookie(session_name(), '', [
    'expires' => time() - 3600,
    'path' => $params['path'] ?: '/',
    'domain' => $params['domain'],
    'secure' => $params['secure'],
    'httponly' => $params['httponly'],
    'samesite' => $params['samesite']
]);

session_destroy();

reponseJson([
    'success' => true,
    'message' => 'Déconnexion réussie.'
]);
