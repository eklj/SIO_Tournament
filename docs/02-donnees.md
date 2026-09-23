# Mission 4 - Identification des données

Cette étape décrit les éléments du monde réel que l'application doit mémoriser. Il ne s'agit pas encore de tables SQL.

## Entités et propriétés

### Utilisateur

- identifiant ;
- nom ;
- prénom ;
- pseudo ;
- adresse électronique ;
- mot de passe ;
- rôle sur la plateforme ;
- établissement ;
- option SIO ;
- avatar ;
- date de création ;
- état du compte.

### Jeu

- identifiant ;
- nom ;
- genre ;
- nombre de joueurs par équipe.

### Équipe

- identifiant ;
- nom ;
- description ;
- logo ;
- date de création ;
- statut.

### Tournoi

- identifiant ;
- nom ;
- description ;
- date de début ;
- date de fin ;
- date limite d'inscription ;
- nombre maximal d'équipes ;
- format ;
- statut.

### Inscription

- identifiant ;
- date d'inscription ;
- statut de l'inscription.

### Match

- identifiant ;
- numéro du tour ;
- date prévue ;
- date jouée ;
- statut ;
- format du match.

### Participation à un match

- position de l'équipe ;
- score ;
- indication de victoire.

### Classement

- identifiant ;
- rang ;
- points ;
- nombre de matchs joués ;
- victoires ;
- défaites.

## Relations entre les entités

- Un utilisateur peut appartenir à une ou plusieurs équipes au cours du temps.
- Une équipe possède un capitaine et plusieurs membres.
- Une équipe est associée à un jeu.
- Un jeu peut être associé à plusieurs équipes et plusieurs tournois.
- Un administrateur peut organiser plusieurs tournois.
- Une équipe peut s'inscrire à plusieurs tournois.
- Un tournoi peut accueillir plusieurs équipes.
- Un tournoi contient plusieurs matchs.
- Un match oppose exactement deux équipes.
- Une équipe peut participer à plusieurs matchs.
- Un tournoi possède un classement contenant les équipes inscrites.
