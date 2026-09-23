-- Plateforme E-sport SIO
-- Script MySQL / MariaDB destiné à l'import dans MCD Creator.
-- Encodage recommandé : UTF-8

CREATE TABLE jeu (
    id_jeu INT UNSIGNED AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    genre VARCHAR(100),
    nombre_joueurs_equipe TINYINT UNSIGNED NOT NULL DEFAULT 1,
    CONSTRAINT pk_jeu PRIMARY KEY (id_jeu),
    CONSTRAINT uq_jeu_nom UNIQUE (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE utilisateur (
    id_utilisateur INT UNSIGNED AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role_plateforme ENUM('JOUEUR', 'ADMINISTRATEUR') NOT NULL DEFAULT 'JOUEUR',
    etablissement VARCHAR(150),
    option_sio ENUM('SLAM', 'SISR', 'AUTRE'),
    avatar_url VARCHAR(500),
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    actif BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT pk_utilisateur PRIMARY KEY (id_utilisateur),
    CONSTRAINT uq_utilisateur_pseudo UNIQUE (pseudo),
    CONSTRAINT uq_utilisateur_email UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE equipe (
    id_equipe INT UNSIGNED AUTO_INCREMENT,
    id_capitaine INT UNSIGNED NOT NULL,
    id_jeu INT UNSIGNED NOT NULL,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    logo_url VARCHAR(500),
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('OUVERTE', 'FERMEE', 'ARCHIVEE') NOT NULL DEFAULT 'OUVERTE',
    CONSTRAINT pk_equipe PRIMARY KEY (id_equipe),
    CONSTRAINT uq_equipe_nom_jeu UNIQUE (nom, id_jeu),
    CONSTRAINT fk_equipe_capitaine FOREIGN KEY (id_capitaine)
        REFERENCES utilisateur (id_utilisateur)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_equipe_jeu FOREIGN KEY (id_jeu)
        REFERENCES jeu (id_jeu)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE membre_equipe (
    id_equipe INT UNSIGNED NOT NULL,
    id_utilisateur INT UNSIGNED NOT NULL,
    role_equipe ENUM('CAPITAINE', 'TITULAIRE', 'REMPLACANT') NOT NULL DEFAULT 'TITULAIRE',
    date_arrivee DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_membre_equipe PRIMARY KEY (id_equipe, id_utilisateur),
    CONSTRAINT fk_membre_equipe_equipe FOREIGN KEY (id_equipe)
        REFERENCES equipe (id_equipe)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_membre_equipe_utilisateur FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateur (id_utilisateur)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE tournoi (
    id_tournoi INT UNSIGNED AUTO_INCREMENT,
    id_jeu INT UNSIGNED NOT NULL,
    id_organisateur INT UNSIGNED NOT NULL,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    date_debut DATETIME NOT NULL,
    date_fin DATETIME,
    date_limite_inscription DATETIME NOT NULL,
    nombre_equipes_max SMALLINT UNSIGNED,
    format_tournoi ENUM('ELIMINATION_DIRECTE', 'CHAMPIONNAT', 'GROUPES_PUIS_FINALE') NOT NULL,
    statut ENUM('BROUILLON', 'INSCRIPTIONS', 'EN_COURS', 'TERMINE', 'ANNULE') NOT NULL DEFAULT 'BROUILLON',
    CONSTRAINT pk_tournoi PRIMARY KEY (id_tournoi),
    CONSTRAINT fk_tournoi_jeu FOREIGN KEY (id_jeu)
        REFERENCES jeu (id_jeu)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_tournoi_organisateur FOREIGN KEY (id_organisateur)
        REFERENCES utilisateur (id_utilisateur)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT ck_tournoi_dates CHECK (date_fin IS NULL OR date_fin >= date_debut),
    CONSTRAINT ck_tournoi_limite CHECK (date_limite_inscription <= date_debut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE inscription_tournoi (
    id_inscription INT UNSIGNED AUTO_INCREMENT,
    id_tournoi INT UNSIGNED NOT NULL,
    id_equipe INT UNSIGNED NOT NULL,
    date_inscription DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('EN_ATTENTE', 'VALIDEE', 'REFUSEE', 'ANNULEE') NOT NULL DEFAULT 'EN_ATTENTE',
    CONSTRAINT pk_inscription_tournoi PRIMARY KEY (id_inscription),
    CONSTRAINT uq_inscription_tournoi_equipe UNIQUE (id_tournoi, id_equipe),
    CONSTRAINT fk_inscription_tournoi_tournoi FOREIGN KEY (id_tournoi)
        REFERENCES tournoi (id_tournoi)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_inscription_tournoi_equipe FOREIGN KEY (id_equipe)
        REFERENCES equipe (id_equipe)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE match_esport (
    id_match INT UNSIGNED AUTO_INCREMENT,
    id_tournoi INT UNSIGNED NOT NULL,
    numero_tour SMALLINT UNSIGNED,
    date_prevue DATETIME,
    date_jouee DATETIME,
    statut ENUM('PLANIFIE', 'EN_COURS', 'TERMINE', 'ANNULE') NOT NULL DEFAULT 'PLANIFIE',
    meilleur_de TINYINT UNSIGNED NOT NULL DEFAULT 1,
    CONSTRAINT pk_match_esport PRIMARY KEY (id_match),
    CONSTRAINT fk_match_esport_tournoi FOREIGN KEY (id_tournoi)
        REFERENCES tournoi (id_tournoi)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT ck_match_meilleur_de CHECK (meilleur_de >= 1 AND MOD(meilleur_de, 2) = 1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE participation_match (
    id_match INT UNSIGNED NOT NULL,
    id_equipe INT UNSIGNED NOT NULL,
    position_equipe TINYINT UNSIGNED NOT NULL,
    score SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    gagnante BOOLEAN NOT NULL DEFAULT FALSE,
    CONSTRAINT pk_participation_match PRIMARY KEY (id_match, id_equipe),
    CONSTRAINT uq_participation_position UNIQUE (id_match, position_equipe),
    CONSTRAINT fk_participation_match_match FOREIGN KEY (id_match)
        REFERENCES match_esport (id_match)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_participation_match_equipe FOREIGN KEY (id_equipe)
        REFERENCES equipe (id_equipe)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT ck_participation_position CHECK (position_equipe IN (1, 2))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE classement (
    id_classement INT UNSIGNED AUTO_INCREMENT,
    id_tournoi INT UNSIGNED NOT NULL,
    id_equipe INT UNSIGNED NOT NULL,
    rang SMALLINT UNSIGNED,
    points INT NOT NULL DEFAULT 0,
    matchs_joues SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    victoires SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    defaites SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    CONSTRAINT pk_classement PRIMARY KEY (id_classement),
    CONSTRAINT uq_classement_equipe UNIQUE (id_tournoi, id_equipe),
    CONSTRAINT uq_classement_rang UNIQUE (id_tournoi, rang),
    CONSTRAINT fk_classement_tournoi FOREIGN KEY (id_tournoi)
        REFERENCES tournoi (id_tournoi)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_classement_equipe FOREIGN KEY (id_equipe)
        REFERENCES equipe (id_equipe)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT ck_classement_resultats CHECK (victoires + defaites <= matchs_joues)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE vote_mvp (
    id_vote INT UNSIGNED AUTO_INCREMENT,
    id_match INT UNSIGNED NOT NULL,
    id_votant INT UNSIGNED NOT NULL,
    id_joueur_choisi INT UNSIGNED NOT NULL,
    date_vote DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_vote_mvp PRIMARY KEY (id_vote),
    CONSTRAINT uq_vote_mvp UNIQUE (id_match, id_votant),
    CONSTRAINT fk_vote_mvp_match FOREIGN KEY (id_match)
        REFERENCES match_esport (id_match)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_vote_mvp_votant FOREIGN KEY (id_votant)
        REFERENCES utilisateur (id_utilisateur)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_vote_mvp_joueur FOREIGN KEY (id_joueur_choisi)
        REFERENCES utilisateur (id_utilisateur)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
