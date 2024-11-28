/*---------------------------------------*/
/*                 Taches                */
/*---------------------------------------*/

CREATE VIEW taskflow.VueCartesTaches AS
SELECT
    taskflow.Taches.id                                             AS id_tache,
    taskflow.Taches.id_utilisateur                                 AS id_utilisateur,
    taskflow.Taches.titre                                          AS titre,
    taskflow.Taches.detail                                         AS detail,
    EXTRACT(DAY FROM taskflow.Taches.echeance - CURRENT_TIMESTAMP) AS nb_jours_avant_echeance,
    taskflow.Taches.echeance                                       AS date_echeance,
    statut.libelle                                                 AS libelle_statut,
    statut.couleur                                                 AS couleur_statut,
    priorite.libelle                                               AS libelle_priorite,
    priorite.couleur                                               AS couleur_priorite,
    COUNT(taskflow.Commentaires.id_commentaire)                   AS nb_commentaires
FROM
    taskflow.Taches
    -- Jointure pour récupérer les informations sur le statut
    JOIN taskflow.Intitules statut ON taskflow.Taches.id_statut = statut.id
    -- Jointure pour récupérer les informations sur la priorité
    JOIN taskflow.Intitules priorite ON taskflow.Taches.id_priorite = priorite.id
    -- Jointure pour récupérer les commentaires associés
    LEFT JOIN taskflow.Commentaires ON taskflow.Taches.id = taskflow.Commentaires.id_tache
GROUP BY
    taskflow.Taches.id,
    taskflow.Taches.id_utilisateur,
    taskflow.Taches.titre,
    taskflow.Taches.detail,
    taskflow.Taches.echeance,
    statut.libelle,
    statut.couleur,
    priorite.libelle,
    priorite.couleur;
