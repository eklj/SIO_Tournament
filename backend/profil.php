<?php
require_once __DIR__ . '/auth.php';
header('Cache-Control: no-store');
$utilisateur = exigerConnexion();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Mon profil — SIO Tournament</title></head>
<body>
<h1>Mon profil</h1>
<dl>
<?php foreach (['pseudo' => 'Pseudo', 'nom' => 'Nom', 'prenom' => 'Prénom', 'email' => 'Email', 'etablissement' => 'Établissement', 'option_sio' => 'Option SIO'] as $champ => $label): ?>
<dt><?= h($label) ?></dt><dd><?= h((string) ($utilisateur[$champ] ?? 'Non renseigné')) ?></dd>
<?php endforeach; ?>
</dl>
<p><a href="../frontend/index.html">Accueil</a></p>
<form method="post" action="logout.php"><input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>"><button type="submit">Déconnexion</button></form>
</body></html>
