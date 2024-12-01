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
    id_jeton_resetMdp    INT,
    id_jeton_seSouvenir  INT,
    FOREIGN KEY (id_personne        ) REFERENCES taskflow.Personnes(id),
    FOREIGN KEY (id_jeton_resetMdp  ) REFERENCES taskflow.Jetons   (id),
    FOREIGN KEY (id_jeton_seSouvenir) REFERENCES taskflow.Jetons   (id)
);

/*---------------------------------------*/
/*                 Taches                */
/*---------------------------------------*/ 

-- Table Intitules
CREATE TABLE taskflow.Intitules (
    id              SERIAL       PRIMARY KEY,
    id_utilisateur  INT          NOT NULL,
    type_intitule   VARCHAR(20) NOT NULL CHECK (type_intitule IN ('statut', 'priorite')),
    libelle         VARCHAR(30) NOT NULL,
    couleur         VARCHAR(7)   NOT NULL DEFAULT '#B9B9B9', -- gris par défaut
    est_supprimable BOOLEAN      NOT NULL DEFAULT TRUE,
    FOREIGN KEY (id_utilisateur) REFERENCES taskflow.Utilisateurs(id_personne)
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
    nbRappel       INT DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (id_utilisateur) REFERENCES taskflow.Utilisateurs(id_personne),
    FOREIGN KEY (id_statut)      REFERENCES taskflow.Intitules    (id),
    FOREIGN KEY (id_priorite)    REFERENCES taskflow.Intitules    (id)
    /*CHECK (id_priorite IN (SELECT id FROM taskflow.Intitules WHERE type_intitule = 'priorite')),
    CHECK (id_statut   IN (SELECT id FROM taskflow.Intitules WHERE type_intitule = 'statut'))*/
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
