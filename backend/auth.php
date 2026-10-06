<?php
require_once __DIR__ . '/fonctions.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'path' => '/',
    ]);
    session_start();
}
$_SESSION['csrf'] ??= bin2hex(random_bytes(32));
function verifierCsrf(): bool {
    $token = $_POST['csrf'] ?? null;
    return is_string($token) && hash_equals($_SESSION['csrf'], $token);
}
function utilisateurConnecte(): ?array {
    if (!isset($_SESSION['id_utilisateur'])) return null;
    require __DIR__ . '/connexion.php';
    $stmt = $pdo->prepare('SELECT id_utilisateur, nom, prenom, pseudo, email, role_plateforme, etablissement, option_sio FROM utilisateur WHERE id_utilisateur = ? AND actif = TRUE');
    $stmt->execute([$_SESSION['id_utilisateur']]);
    $utilisateur = $stmt->fetch();
    if (!$utilisateur) {
        unset($_SESSION['id_utilisateur'], $_SESSION['id_joueur'], $_SESSION['pseudo'], $_SESSION['role_plateforme']);
        return null;
    }
    $_SESSION['role_plateforme'] = $utilisateur['role_plateforme'];
    $_SESSION['pseudo'] = $utilisateur['pseudo'];
    return $utilisateur;
}
function exigerConnexion(): array {
    $utilisateur = utilisateurConnecte();
    if (!$utilisateur) {
        header('Location: login.php', true, 303);
        exit;
    }
    return $utilisateur;
}
function exigerAdministrateur(): array {
    $utilisateur = exigerConnexion();
    if ($utilisateur['role_plateforme'] !== 'ADMINISTRATEUR') {
        http_response_code(403);
        exit('Accès réservé aux administrateurs.');
    }
    return $utilisateur;
}
