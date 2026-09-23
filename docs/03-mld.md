# Mission 6 - Modèle logique de données

Les clés primaires sont indiquées par `PK` et les clés étrangères par `FK`.

## UTILISATEUR

- `id_utilisateur` PK
- `nom`
- `prenom`
- `pseudo` UNIQUE
- `email` UNIQUE
- `mot_de_passe`
- `role_plateforme`
- `etablissement`
- `option_sio`
- `avatar_url`
- `date_creation`
- `actif`

## JEU

- `id_jeu` PK
- `nom` UNIQUE
- `genre`
- `nombre_joueurs_equipe`

## EQUIPE

- `id_equipe` PK
- `nom`
- `description`
- `logo_url`
- `date_creation`
- `statut`
- `id_capitaine` FK vers UTILISATEUR
- `id_jeu` FK vers JEU

## MEMBRE_EQUIPE

- `id_equipe` PK, FK vers EQUIPE
- `id_utilisateur` PK, FK vers UTILISATEUR
- `role_equipe`
- `date_arrivee`

## TOURNOI

- `id_tournoi` PK
- `nom`
- `description`
- `date_debut`
- `date_fin`
- `date_limite_inscription`
- `nombre_equipes_max`
- `format_tournoi`
- `statut`
- `id_jeu` FK vers JEU
- `id_organisateur` FK vers UTILISATEUR

## INSCRIPTION_TOURNOI

- `id_inscription` PK
- `date_inscription`
- `statut`
- `id_tournoi` FK vers TOURNOI
- `id_equipe` FK vers EQUIPE

Contrainte d'unicité : une équipe ne peut s'inscrire qu'une fois au même tournoi.

## MATCH_ESPORT

- `id_match` PK
- `numero_tour`
- `date_prevue`
- `date_jouee`
- `statut`
- `meilleur_de`
- `id_tournoi` FK vers TOURNOI

## PARTICIPATION_MATCH

- `id_match` PK, FK vers MATCH_ESPORT
- `id_equipe` PK, FK vers EQUIPE
- `position_equipe`
- `score`
- `gagnante`

## CLASSEMENT

- `id_classement` PK
- `rang`
- `points`
- `matchs_joues`
- `victoires`
- `defaites`
- `id_tournoi` FK vers TOURNOI
- `id_equipe` FK vers EQUIPE

## Table bonus : VOTE_MVP

- `id_vote` PK
- `date_vote`
- `id_match` FK vers MATCH_ESPORT
- `id_votant` FK vers UTILISATEUR
- `id_joueur_choisi` FK vers UTILISATEUR

Cette dernière table appartient aux fonctionnalités bonus et pourra être développée uniquement après le MVP.
