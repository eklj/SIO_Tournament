# Organisation actuelle

Le projet utilise PostgreSQL et des formulaires PHP qui produisent du HTML.
L'accueil est frontend/index.html. Il utilise frontend/js/auth.js et
backend/session.php pour afficher l'état de connexion.

- connexion.php : connexion PDO, paramètres conservés.
- fonctions.php : échappement HTML commun.
- auth.php : sessions et contrôle des droits.
- signin.php : inscription ; login.php : connexion.
- logout.php : déconnexion POST avec CSRF.
- profil.php : consultation du profil (modification non implémentée).

Lancement depuis la racine : php -S localhost:8000
Accueil : http://localhost:8000/frontend/index.html
Ne pas ouvrir index.html directement avec file:// ou un serveur Live Server.
Le document 05-api.md est un contrat envisagé, pas une API REST implémentée.
Les équipes, tournois et classements restent à développer.
Les helpers de droits doivent être appelés par chaque future page protégée.

Vérifications : inscription, doublon, mauvais mot de passe, connexion,
affichage du pseudo, profil privé, déconnexion et refus du profil déconnecté.
