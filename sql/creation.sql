-- Création du schéma
CREATE SCHEMA IF NOT EXISTS taskflow;

    /*---------------------------------------*/
    /*              Utilisateurs             */
    /*---------------------------------------*/ 

-- Table Jetons
CREATE TABLE taskflow.Jetons (
    id         SERIAL       PRIMARY KEY,
    jeton      VARCHAR(255) NOT NULL,
    expiration TIMESTAMP    NOT NULL
);

-- Table Personnes
CREATE TABLE taskflow.Personnes (
    id    SERIAL       PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    nom   VARCHAR(255) NOT NULL,
    mdp   VARCHAR(255) NOT NULL
);

-- Table Inscriptions
CREATE TABLE taskflow.Inscriptions (
    id_personne INT NOT NULL,
    id_jeton    INT NOT NULL,
    PRIMARY KEY (id_personne, id_jeton),
    FOREIGN KEY (id_personne)           REFERENCES taskflow.Personnes(id),
    FOREIGN KEY (id_jeton)              REFERENCES taskflow.Jetons   (id)
);

-- Table Utilisateurs
CREATE TABLE taskflow.Utilisateurs (
    id_personne INT NOT NULL PRIMARY KEY,
    id_jeton    INT,
    FOREIGN KEY (id_personne) REFERENCES taskflow.Personnes(id),
    FOREIGN KEY (id_jeton)    REFERENCES taskflow.Jetons   (id)
);

    /*---------------------------------------*/
    /*                 Taches                */
    /*---------------------------------------*/ 

-- Table Intitule
CREATE TABLE taskflow.Intitule (
    id      SERIAL       PRIMARY KEY,
    libelle VARCHAR(255) NOT NULL,
    couleur INT          NOT NULL DEFAULT 16777216 -- blanc par défaut : 256*256*256 - 1
);

-- Table StatutUtilisateur
CREATE TABLE taskflow.StatutUtilisateur (
    id_statut      INT     NOT NULL,
    id_utilisateur INT     NOT NULL,
    estModifiable  BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id_statut, id_utilisateur),
    FOREIGN KEY (id_statut)                 REFERENCES taskflow.Intitule    (id),
    FOREIGN KEY (id_utilisateur)            REFERENCES taskflow.Utilisateurs(id_personne)
);

-- Table PrioriteUtilisateur
CREATE TABLE taskflow.PrioriteUtilisateur (
    id_priorite    INT     NOT NULL,
    id_utilisateur INT     NOT NULL,
    estModifiable  BOOLEAN NOT NULL,
    PRIMARY KEY (id_priorite, id_utilisateur),
    FOREIGN KEY (id_priorite)                 REFERENCES taskflow.Intitule    (id),
    FOREIGN KEY (id_utilisateur)              REFERENCES taskflow.Utilisateurs(id_personne)
);

-- Table Taches
CREATE TABLE taskflow.Taches (
    id             SERIAL    NOT NULL,
    id_utilisateur INT       NOT NULL,
    titre          TEXT      NOT NULL,
    detail         TEXT      NOT NULL DEFAULT '',
    ajoutee_le     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    rappel         INT,
    echeance       TIMESTAMP NOT NULL,
    id_priorite    INT       NOT NULL,
    id_statut      INT       NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_utilisateur)     REFERENCES taskflow.Utilisateurs(id_personne),
    FOREIGN KEY (id_statut)          REFERENCES taskflow.Intitule    (id)
);

    /*---------------------------------------*/
    /*              Commentaires             */
    /*---------------------------------------*/ 

-- Table Commentaires
CREATE TABLE taskflow.Commentaires (
    id_commentaire SERIAL    NOT NULL,
    id_tache       INT       NOT NULL,
    commentaire    TEXT      NOT NULL DEFAULT '',
    ajoutee_le     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_commentaire),
    FOREIGN KEY (id_tache)       REFERENCES taskflow.Taches(id)
);
