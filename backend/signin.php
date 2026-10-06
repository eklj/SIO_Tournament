<?php
declare(strict_types=1);

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

$nom = trim((string) ($donnees['nom'] ?? ''));
$prenom = trim((string) ($donnees['prenom'] ?? ''));
$pseudo = trim((string) ($donnees['pseudo'] ?? ''));
$email = strtolower(trim((string) ($donnees['email'] ?? '')));
$motDePasse = (string) ($donnees['mot_de_passe'] ?? '');
$confirmation = (string) ($donnees['confirmation'] ?? '');

$erreurs = [];

if (
    $nom === ''
    || $prenom === ''
    || $pseudo === ''
    || $email === ''
    || $motDePasse === ''
    || $confirmation === ''
) {
    $erreurs[] = 'Tous les champs sont obligatoires.';
}

if (strlen($nom) > 100) {
    $erreurs[] = 'Le nom est trop long.';
}

if (strlen($prenom) > 100) {
    $erreurs[] = 'Le prénom est trop long.';
}

if (strlen($pseudo) < 3 || strlen($pseudo) > 50) {
    $erreurs[] = 'Le pseudo doit contenir entre 3 et 50 caractères.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = "L'adresse email n'est pas valide.";
}

if (strlen($motDePasse) < 8 || strlen($motDePasse) > 72) {
    $erreurs[] = 'Le mot de passe doit contenir entre 8 et 72 caractères.';
}

if ($motDePasse !== $confirmation) {
    $erreurs[] = 'Les mots de passe ne correspondent pas.';
}

if ($erreurs !== []) {
    reponseJson([
        'success' => false,
        'message' => 'Les données envoyées sont invalides.',
        'errors' => array_values(array_unique($erreurs))
    ], 422);
}

require_once __DIR__ . '/connexion.php';

try {
    $requete = $pdo->prepare(
        'INSERT INTO utilisateur
            (nom, prenom, pseudo, email, mot_de_passe)
         VALUES
            (:nom, :prenom, :pseudo, :email, :mot_de_passe)
         RETURNING id_utilisateur, pseudo, email, role_plateforme'
    );

    $requete->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'pseudo' => $pseudo,
        'email' => $email,
        'mot_de_passe' => password_hash($motDePasse, PASSWORD_BCRYPT)
    ]);

    $utilisateur = $requete->fetch();

    reponseJson([
        'success' => true,
        'message' => 'Compte créé avec succès.',
        'user' => [
            'id_utilisateur' => (int) $utilisateur['id_utilisateur'],
            'pseudo' => $utilisateur['pseudo'],
            'email' => $utilisateur['email'],
            'role_plateforme' => $utilisateur['role_plateforme']
        ]
    ], 201);
} catch (PDOException $exception) {
    if ($exception->getCode() === '23505') {
        reponseJson([
            'success' => false,
            'message' => 'Ce pseudo ou cet email est déjà utilisé.'
        ], 409);
    }

    error_log('API signin : ' . $exception->getMessage());

    reponseJson([
        'success' => false,
        'message' => "Une erreur interne est survenue pendant l'inscription."
    ], 500);
}
