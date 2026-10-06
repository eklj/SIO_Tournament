<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/connexion.php';
$erreurs = [];
$succes = '';
$valeurs = ['nom' => '', 'prenom' => '', 'pseudo' => '', 'email' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($valeurs as $champ => $_) {
        $valeurs[$champ] = is_string($_POST[$champ] ?? null) ? trim($_POST[$champ]) : '';
    }
    $mdp = is_string($_POST['mot_de_passe'] ?? null) ? $_POST['mot_de_passe'] : '';
    $confirmation = is_string($_POST['confirmation'] ?? null) ? $_POST['confirmation'] : '';
    $csrf = is_string($_POST['csrf'] ?? null) ? $_POST['csrf'] : '';
    if (!hash_equals($_SESSION['csrf'], $csrf)) {
        $erreurs[] = 'Formulaire expiré. Recharge la page et réessaie.';
    }
    foreach ($valeurs as $valeur) {
        if ($valeur === '') {
            $erreurs[] = 'Tous les champs sont obligatoires.';
            break;
        }
    }
    foreach (['nom' => 100, 'prenom' => 100, 'pseudo' => 50, 'email' => 255] as $champ => $max) {
        $longueur = preg_match_all('/./us', $valeurs[$champ]);
        if ($longueur === false) {
            $erreurs[] = "Le champ $champ contient un texte invalide.";
        } elseif ($longueur > $max) {
            $erreurs[] = "Le champ $champ est trop long.";
        }
    }
    if (!filter_var($valeurs['email'], FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }
    // PASSWORD_BCRYPT limite le mot de passe à 72 octets.
    if (strlen($mdp) < 8 || strlen($mdp) > 72) {
        $erreurs[] = 'Le mot de passe doit contenir entre 8 et 72 octets.';
    }
    if ($mdp !== $confirmation) {
        $erreurs[] = 'Les mots de passe ne correspondent pas.';
    }
    if (!$erreurs) {
        try {
            $stmt = $pdo->prepare('INSERT INTO utilisateur (nom, prenom, pseudo, email, mot_de_passe) VALUES (:nom, :prenom, :pseudo, :email, :mot_de_passe)');
            $stmt->execute($valeurs + ['mot_de_passe' => password_hash($mdp, PASSWORD_BCRYPT)]);
            $_SESSION['inscription_succes'] = 'Inscription réussie. Tu peux maintenant te connecter.';
            header('Location: signin.php', true, 303);
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                $erreurs[] = 'Ce pseudo ou cet email est déjà utilisé.';
            } else {
                error_log('Inscription : ' . $e->getMessage());
                $erreurs[] = "L'inscription a échoué. Réessaie plus tard.";
            }
        }
    }
}
$succes = $_SESSION['inscription_succes'] ?? '';
unset($_SESSION['inscription_succes']);
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Inscription — SIO Tournament</title><link rel="stylesheet" href="style.css"></head>
<body><div class="conteneur">
<h1>Créer un compte</h1>
<?php if ($erreurs): ?><div class="messages erreur" role="alert"><ul><?php foreach ($erreurs as $erreur): ?><li><?= h($erreur) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<?php if ($succes): ?><div class="messages succes" role="status"><?= h($succes) ?></div><?php endif; ?>
<form method="post" action="signin.php">
<input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>">
<label for="nom">Nom</label><input id="nom" name="nom" maxlength="100" value="<?= h($valeurs['nom']) ?>" autocomplete="family-name" required>
<label for="prenom">Prénom</label><input id="prenom" name="prenom" maxlength="100" value="<?= h($valeurs['prenom']) ?>" autocomplete="given-name" required>
<label for="pseudo">Pseudo</label><input id="pseudo" name="pseudo" maxlength="50" value="<?= h($valeurs['pseudo']) ?>" autocomplete="username" required>
<label for="email">Email</label><input type="email" id="email" name="email" maxlength="255" value="<?= h($valeurs['email']) ?>" autocomplete="email" required>
<label for="mot_de_passe">Mot de passe</label><input type="password" id="mot_de_passe" name="mot_de_passe" minlength="8" autocomplete="new-password" required>
<label for="confirmation">Confirmer le mot de passe</label><input type="password" id="confirmation" name="confirmation" minlength="8" autocomplete="new-password" required>
<button type="submit">S'inscrire</button>
</form>
<p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
<p><a href="../frontend/index.html">Accueil</a></p>
</div></body></html>
