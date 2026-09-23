# Mission 9 - Contrat de l'API REST

Toutes les réponses sont envoyées au format JSON. Les routes nécessitant des droits d'administration seront protégées.

## Authentification et utilisateurs

| Méthode | Route | Fonction |
|---|---|---|
| POST | `/api/auth/inscription` | Créer un compte |
| POST | `/api/auth/connexion` | Connecter un utilisateur |
| POST | `/api/auth/deconnexion` | Déconnecter l'utilisateur |
| GET | `/api/utilisateurs/{id}` | Récupérer un profil |
| PUT | `/api/utilisateurs/{id}` | Modifier un profil |
| GET | `/api/utilisateurs` | Lister les utilisateurs - administrateur |
| DELETE | `/api/utilisateurs/{id}` | Désactiver un compte - administrateur |

## Jeux

| Méthode | Route | Fonction |
|---|---|---|
| GET | `/api/jeux` | Récupérer tous les jeux |
| GET | `/api/jeux/{id}` | Récupérer un jeu |
| POST | `/api/jeux` | Ajouter un jeu - administrateur |
| PUT | `/api/jeux/{id}` | Modifier un jeu - administrateur |
| DELETE | `/api/jeux/{id}` | Retirer un jeu - administrateur |

## Équipes

| Méthode | Route | Fonction |
|---|---|---|
| GET | `/api/equipes` | Récupérer les équipes |
| GET | `/api/equipes/{id}` | Récupérer une équipe et ses membres |
| POST | `/api/equipes` | Créer une équipe |
| PUT | `/api/equipes/{id}` | Modifier une équipe - capitaine |
| DELETE | `/api/equipes/{id}` | Archiver une équipe - capitaine ou administrateur |
| POST | `/api/equipes/{id}/membres` | Ajouter ou rejoindre une équipe |
| DELETE | `/api/equipes/{id}/membres/{utilisateurId}` | Quitter ou retirer un membre |

## Tournois et inscriptions

| Méthode | Route | Fonction |
|---|---|---|
| GET | `/api/tournois` | Récupérer les tournois |
| GET | `/api/tournois/{id}` | Récupérer un tournoi |
| POST | `/api/tournois` | Créer un tournoi - administrateur |
| PUT | `/api/tournois/{id}` | Modifier un tournoi - administrateur |
| DELETE | `/api/tournois/{id}` | Annuler un tournoi - administrateur |
| GET | `/api/tournois/{id}/inscriptions` | Lister les équipes inscrites |
| POST | `/api/tournois/{id}/inscriptions` | Inscrire une équipe |
| PUT | `/api/inscriptions/{id}` | Valider ou refuser une inscription |
| DELETE | `/api/inscriptions/{id}` | Annuler une inscription |

## Matchs et classements

| Méthode | Route | Fonction |
|---|---|---|
| GET | `/api/matchs` | Récupérer les matchs |
| GET | `/api/matchs/{id}` | Récupérer un match |
| POST | `/api/tournois/{id}/matchs` | Planifier un match - administrateur |
| PUT | `/api/matchs/{id}` | Modifier la date ou le statut d'un match |
| PUT | `/api/matchs/{id}/resultat` | Enregistrer ou valider le résultat |
| GET | `/api/tournois/{id}/classement` | Récupérer le classement d'un tournoi |

## Exemples de codes HTTP

- `200 OK` : requête réussie ;
- `201 Created` : ressource créée ;
- `400 Bad Request` : données invalides ;
- `401 Unauthorized` : utilisateur non connecté ;
- `403 Forbidden` : droits insuffisants ;
- `404 Not Found` : ressource introuvable ;
- `409 Conflict` : inscription ou pseudo déjà existant ;
- `500 Internal Server Error` : erreur du serveur.
