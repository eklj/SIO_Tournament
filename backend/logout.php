<?php
require_once __DIR__ . '/auth.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Utilise le bouton Déconnexion.');
}
if (!verifierCsrf()) {
    http_response_code(403);
    exit('Formulaire expiré. Recharge la page.');
}
$_SESSION = [];
$params = session_get_cookie_params();
setcookie(session_name(), '', [
    'expires' => time() - 3600,
    'path' => $params['path'], 'domain' => $params['domain'],
    'secure' => $params['secure'], 'httponly' => $params['httponly'],
    'samesite' => $params['samesite'],
]);
session_destroy();
header('Location: ../frontend/index.html', true, 303);
exit;
