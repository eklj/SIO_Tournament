<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

session_set_cookie_params([
    'httponly' => true,
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'samesite' => 'Lax',
    'path' => '/'
]);

session_start();

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

$typeContenu = $_SERVER['CONTENT_TYPE'] ?? '';

if (!str_contains(strtolower($typeContenu), 'application/json')) {
    reponseJson([
        'success' => false,
        'message' => 'Le contenu doit être envoyé au format JSON.'
    ], 415);
}

$donnees = json_decode(file_get_contents('php://input'), true);

if (!is_array($donnees)) {
    reponseJson([
        'success' => false,
        'message' => 'Corps JSON invalide.'
    ], 400);
}

$pseudo = trim((string) ($donnees['pseudo'] ?? ''));
$motDePasse = (string) (
    $donnees['mot_de_passe']
    ?? $donnees['password']
    ?? ''
);

if ($pseudo === '' || $motDePasse === '') {
    reponseJson([
        'success' => false,
        'message' => 'Le pseudo et le mot de passe sont obligatoires.'
    ], 422);
}

require_once __DIR__ . '/connexion.php';

try {
    $requete = $pdo->prepare(
        'SELECT
            id_utilisateur,
            pseudo,
            email,
            mot_de_passe,
            role_plateforme
         FROM utilisateur
         WHERE pseudo = :pseudo
           AND actif = TRUE'
    );

    $requete->execute(['pseudo' => $pseudo]);
    $utilisateur = $requete->fetch();

    if (
        !$utilisateur
        || !password_verify($motDePasse, $utilisateur['mot_de_passe'])
    ) {
        reponseJson([
            'success' => false,
            'message' => 'Pseudo ou mot de passe incorrect.'
        ], 401);
    }

    session_regenerate_id(true);

    $_SESSION['id_utilisateur'] = (int) $utilisateur['id_utilisateur'];
    $_SESSION['id_joueur'] = (int) $utilisateur['id_utilisateur'];
    $_SESSION['pseudo'] = $utilisateur['pseudo'];
    $_SESSION['role_plateforme'] = $utilisateur['role_plateforme'];

    reponseJson([
        'success' => true,
        'message' => 'Connexion réussie.',
        'user' => [
            'id_utilisateur' => (int) $utilisateur['id_utilisateur'],
            'pseudo' => $utilisateur['pseudo'],
            'email' => $utilisateur['email'],
            'role_plateforme' => $utilisateur['role_plateforme']
        ]
    ]);
} catch (PDOException $exception) {
    error_log('API login : ' . $exception->getMessage());

    reponseJson([
        'success' => false,
        'message' => 'Une erreur interne est survenue.'
    ], 500);
}
