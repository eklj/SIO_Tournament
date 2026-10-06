<?php
session_start();
require_once __DIR__ . '/connexion.php';
$_SESSION['csrf'] ??= bin2hex(random_bytes(32));
$error = '';
$pseudo = '';
function h(string $valeur): string {
    return htmlspecialchars($valeur, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = is_string($_POST['pseudo'] ?? null) ? trim($_POST['pseudo']) : '';
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    $csrf = is_string($_POST['csrf'] ?? null) ? $_POST['csrf'] : '';
    if (!hash_equals($_SESSION['csrf'], $csrf)) {
        $error = 'Formulaire expiré. Recharge la page et réessaie.';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT id_utilisateur, pseudo, mot_de_passe, role_plateforme FROM utilisateur WHERE pseudo = ? AND actif = TRUE');
            $stmt->execute([$pseudo]);
            $utilisateur = $stmt->fetch();
            if ($utilisateur && password_verify($password, $utilisateur['mot_de_passe'])) {
                session_regenerate_id(true);
                $_SESSION['id_utilisateur'] = (int) $utilisateur['id_utilisateur'];
                // Compatibilité avec le test de connexion dans l'accueil actuel.
                $_SESSION['id_joueur'] = (int) $utilisateur['id_utilisateur'];
                $_SESSION['pseudo'] = $utilisateur['pseudo'];
                $_SESSION['role_plateforme'] = $utilisateur['role_plateforme'];
                $_SESSION['csrf'] = bin2hex(random_bytes(32));
                header('Location: index.php', true, 303);
                exit;
            }
            $error = 'Pseudo ou mot de passe incorrect.';
        } catch (PDOException $e) {
            error_log('Connexion utilisateur : ' . $e->getMessage());
            $error = 'Connexion impossible. Réessaie plus tard.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Connexion — SIO Tournament</title><link rel="stylesheet" href="style.css"></head>
<body><div class="conteneur"><h1>Connexion</h1>
<?php if ($error): ?><div class="messages erreur" role="alert"><?= h($error) ?></div><?php endif; ?>
<form method="post" action="login.php">
<input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
<label for="pseudo">Pseudo</label><input id="pseudo" name="pseudo" value="<?= h($pseudo) ?>" autocomplete="username" required>
<label for="password">Mot de passe</label><input type="password" id="password" name="password" autocomplete="current-password" required>
<button type="submit">Se connecter</button>
</form>
<p>Pas de compte ? <a href="signin.php">Inscrivez-vous</a>.</p>
<p><a href="index.php">Accueil</a></p>
</div></body></html>
