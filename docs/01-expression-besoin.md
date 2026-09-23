# Expression du besoin

## 1. Présentation du contexte

Les étudiants en BTS SIO sont nombreux à partager une passion pour les jeux vidéo et la compétition. Cependant, ils ne disposent pas toujours d'un espace commun spécialement conçu pour organiser des rencontres, créer des équipes et participer à des tournois avec d'autres étudiants de la formation.

Les échanges se font généralement sur plusieurs outils différents, comme les réseaux sociaux ou les applications de messagerie. Cette organisation dispersée rend plus difficiles la recherche de joueurs, la gestion des équipes, la planification des matchs et le suivi des résultats.

Le projet consiste donc à développer une plateforme web d'e-sport destinée principalement aux étudiants en BTS SIO. Elle permettra de regrouper les joueurs dans un même espace et de faciliter l'organisation de compétitions entre étudiants.

### Quel problème l'application cherche-t-elle à résoudre ?

L'application cherche à résoudre le manque d'une plateforme centralisée permettant aux étudiants en SIO de :

- trouver d'autres joueurs partageant les mêmes jeux ;
- créer ou rejoindre une équipe ;
- organiser des tournois et des matchs ;
- s'inscrire aux compétitions proposées ;
- enregistrer et consulter les résultats ;
- suivre le classement des équipes.

### Qui rencontre ce problème ?

Ce problème concerne principalement :

- les étudiants en BTS SIO qui jouent aux jeux vidéo ;
- les joueurs qui souhaitent trouver des partenaires ou des adversaires ;
- les capitaines qui souhaitent créer et gérer une équipe ;
- les organisateurs qui souhaitent mettre en place des tournois ;
- les administrateurs chargés de gérer la plateforme et ses utilisateurs.

### Pourquoi l'application peut-elle être utile ?

Cette plateforme peut être utile car elle centralise toutes les fonctionnalités nécessaires à l'organisation d'activités e-sport. Les utilisateurs pourront gérer leur profil, rejoindre une équipe, s'inscrire à un tournoi, consulter les matchs à venir et suivre les classements depuis une seule application.

Elle permettra également de créer davantage d'échanges entre les étudiants en SIO de différents établissements. Le projet pourra ainsi renforcer l'esprit d'équipe, développer une communauté autour du gaming et proposer des compétitions organisées dans un cadre adapté aux étudiants.

Enfin, cette application constitue un projet informatique complet pour un étudiant en BTS SIO. Elle permet de mettre en pratique la conception d'une base de données, l'authentification, la gestion des droits, les opérations CRUD et le développement d'une interface web dynamique.

## 2. Identification des utilisateurs

L'application comporte trois types d'utilisateurs correspondant à des besoins réels du projet.

### Utilisateur principal : le joueur SIO

Le joueur est un étudiant en BTS SIO qui souhaite participer aux activités e-sport proposées sur la plateforme.

Il doit pouvoir :

- créer un compte et se connecter ;
- consulter et modifier son profil ;
- rechercher un jeu, une équipe ou un tournoi ;
- créer une équipe ou rejoindre une équipe existante ;
- consulter les membres de son équipe ;
- s'inscrire à un tournoi avec son équipe ;
- consulter les matchs à venir ;
- consulter les résultats et les classements ;
- consulter l'historique de ses matchs.

### Capitaine d'équipe

Le capitaine est également un joueur, mais il possède des droits supplémentaires pour gérer son équipe.

Il doit pouvoir :

- créer et personnaliser son équipe ;
- accepter ou retirer des membres ;
- attribuer un rôle aux membres de l'équipe ;
- inscrire son équipe à un tournoi ;
- consulter le calendrier des matchs de son équipe ;
- enregistrer ou confirmer les résultats d'un match.

### Administrateur

L'administrateur assure le bon fonctionnement de la plateforme et organise les compétitions.

Il doit pouvoir :

- consulter et gérer les comptes utilisateurs ;
- gérer les jeux disponibles sur la plateforme ;
- créer, modifier et supprimer un tournoi ;
- valider ou refuser les inscriptions à un tournoi ;
- planifier les matchs ;
- vérifier et valider les résultats ;
- gérer les équipes et les contenus inappropriés ;
- consulter les classements générés par la plateforme.

Les rôles de visiteur, d'arbitre ou de modérateur séparé ne sont pas ajoutés dans la première version, car ils ne sont pas indispensables au fonctionnement du MVP.

## 3. Résumé du projet

**Mon application permet aux étudiants en BTS SIO de créer ou rejoindre une équipe et de participer à des compétitions e-sport afin de faciliter l'organisation des matchs et de réunir les joueurs SIO sur une plateforme commune.**

## Fonctionnalités

### Gestion du compte et du profil

- L'utilisateur doit pouvoir créer un compte.
- L'utilisateur doit pouvoir se connecter et se déconnecter.
- L'utilisateur doit pouvoir consulter son profil.
- L'utilisateur doit pouvoir modifier son profil.
- L'utilisateur doit pouvoir choisir un pseudo et ajouter un avatar.

### Gestion des jeux

- L'utilisateur doit pouvoir consulter la liste des jeux disponibles.
- L'utilisateur doit pouvoir rechercher un jeu.
- L'utilisateur doit pouvoir consulter les équipes et les tournois associés à un jeu.

### Gestion des équipes

- L'utilisateur doit pouvoir consulter la liste des équipes.
- L'utilisateur doit pouvoir rechercher une équipe.
- L'utilisateur doit pouvoir créer une équipe.
- L'utilisateur doit pouvoir rejoindre une équipe.
- L'utilisateur doit pouvoir quitter une équipe.
- L'utilisateur doit pouvoir consulter les informations et les membres de son équipe.
- Le capitaine doit pouvoir modifier les informations de son équipe.
- Le capitaine doit pouvoir accepter ou refuser une demande d'adhésion.
- Le capitaine doit pouvoir retirer un membre de son équipe.
- Le capitaine doit pouvoir attribuer un rôle aux membres de son équipe.

### Gestion des tournois

- L'utilisateur doit pouvoir consulter la liste des tournois.
- L'utilisateur doit pouvoir rechercher un tournoi.
- L'utilisateur doit pouvoir consulter les informations, les règles et les dates d'un tournoi.
- Le capitaine doit pouvoir inscrire son équipe à un tournoi.
- Le capitaine doit pouvoir annuler l'inscription de son équipe avant la date limite.
- L'utilisateur doit pouvoir consulter les équipes inscrites à un tournoi.
- L'administrateur doit pouvoir créer un tournoi.
- L'administrateur doit pouvoir modifier un tournoi.
- L'administrateur doit pouvoir annuler ou supprimer un tournoi.
- L'administrateur doit pouvoir valider ou refuser l'inscription d'une équipe.

### Gestion des matchs et des résultats

- L'utilisateur doit pouvoir consulter les matchs à venir.
- L'utilisateur doit pouvoir consulter les informations d'un match.
- L'utilisateur doit pouvoir consulter les résultats des matchs terminés.
- Le capitaine doit pouvoir enregistrer le score de son équipe.
- Le capitaine adverse doit pouvoir confirmer ou contester le résultat saisi.
- L'administrateur doit pouvoir planifier et modifier un match.
- L'administrateur doit pouvoir valider ou corriger le résultat d'un match.
- L'utilisateur doit pouvoir consulter l'historique de ses matchs.

### Classement

- L'utilisateur doit pouvoir consulter le classement d'un tournoi.
- L'utilisateur doit pouvoir consulter les points, les victoires et les défaites de chaque équipe.
- L'application doit pouvoir mettre à jour le classement après la validation d'un résultat.

### Administration

- L'administrateur doit pouvoir consulter la liste des utilisateurs.
- L'administrateur doit pouvoir rechercher un utilisateur.
- L'administrateur doit pouvoir désactiver ou réactiver un compte.
- L'administrateur doit pouvoir ajouter, modifier ou retirer un jeu de la plateforme.
- L'administrateur doit pouvoir consulter et gérer les équipes.
