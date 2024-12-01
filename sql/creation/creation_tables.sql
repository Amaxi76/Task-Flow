/*---------------------------------------*/
/*              Utilisateurs             */
/*---------------------------------------*/ 

-- Table Jetons
CREATE TABLE taskflow.Jetons (
    id         SERIAL       NOT NULL,
    jeton      VARCHAR(255) NOT NULL,
    expiration TIMESTAMP    NOT NULL,
    PRIMARY KEY (id)
);

-- Table Personnes
CREATE TABLE taskflow.Personnes (
    id    SERIAL       NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    nom   VARCHAR(255) NOT NULL,
    mdp   VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- Table Inscriptions
CREATE TABLE taskflow.Inscriptions (
    id_personne INT NOT NULL,
    id_jeton    INT NOT NULL,
    PRIMARY KEY (id_personne, id_jeton),
    FOREIGN KEY (id_personne) REFERENCES taskflow.Personnes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_jeton   ) REFERENCES taskflow.Jetons   (id) ON DELETE CASCADE
);

-- Table Utilisateurs
CREATE TABLE taskflow.Utilisateurs (
    id_personne          INT NOT NULL,
    id_jeton_resetMdp    INT,
    id_jeton_seSouvenir  INT,
    PRIMARY KEY (id_personne),
    FOREIGN KEY (id_personne        ) REFERENCES taskflow.Personnes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_jeton_resetMdp  ) REFERENCES taskflow.Jetons   (id) ON DELETE SET NULL,
    FOREIGN KEY (id_jeton_seSouvenir) REFERENCES taskflow.Jetons   (id) ON DELETE SET NULL
);

/*---------------------------------------*/
/*                 Taches                */
/*---------------------------------------*/ 

-- Table Intitules
CREATE TABLE taskflow.Intitules (
    id              SERIAL      NOT NULL,
    id_utilisateur  INT         NOT NULL,
    type_intitule   VARCHAR(20) NOT NULL CHECK (type_intitule IN ('statut', 'priorite')),
    libelle         VARCHAR(30) NOT NULL,
    couleur         VARCHAR(7)  NOT NULL DEFAULT '#B9B9B9', -- gris par défaut
    est_supprimable BOOLEAN     NOT NULL DEFAULT TRUE,
    PRIMARY KEY (id),
    FOREIGN KEY (id_utilisateur) REFERENCES taskflow.Utilisateurs(id_personne) ON DELETE CASCADE
);

-- Table Taches
CREATE TABLE taskflow.Taches (
    id             SERIAL    NOT NULL,
    id_utilisateur INT       NOT NULL,
    titre          TEXT      NOT NULL,
    detail         TEXT      NOT NULL DEFAULT '',
    date_ajout     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    rappel         INT,
    date_echeance  TIMESTAMP NOT NULL,
    id_priorite    INT       NOT NULL,
    id_statut      INT       NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_utilisateur) REFERENCES taskflow.Utilisateurs(id_personne) ON DELETE CASCADE,
    FOREIGN KEY (id_statut     ) REFERENCES taskflow.Intitules    (id)         ON DELETE SET NULL,
    FOREIGN KEY (id_priorite   ) REFERENCES taskflow.Intitules    (id)         ON DELETE SET NULL
    /*CHECK (id_priorite IN (SELECT id FROM taskflow.Intitules WHERE type_intitule = 'priorite')),
    CHECK (id_statut   IN (SELECT id FROM taskflow.Intitules WHERE type_intitule = 'statut'))*/
);

/*---------------------------------------*/
/*              Commentaires             */
/*---------------------------------------*/ 

-- Table Commentaires
CREATE TABLE taskflow.Commentaires (
    id          SERIAL    NOT NULL,
    id_tache    INT       NOT NULL,
    commentaire TEXT      NOT NULL DEFAULT '',
    date_ajout  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (id_tache) REFERENCES taskflow.Taches(id) ON DELETE CASCADE
);
