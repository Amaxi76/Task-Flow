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
    taskflow.Intitules.libelle                                     AS libelle_statut,
    taskflow.Intitules.couleur                                     AS couleur_statut,
    taskflow.Intitules.libelle                                     AS libelle_priorite,
    taskflow.Intitules.couleur                                     AS couleur_priorite,
    COUNT(taskflow.Commentaires.id_commentaire)                    AS nb_commentaires
FROM
    taskflow.Taches
    JOIN taskflow.Intitules         ON taskflow.Taches.id_statut = taskflow.Intitules.id
    LEFT JOIN taskflow.Commentaires ON taskflow.Taches.id = taskflow.Commentaires.id_tache
GROUP BY
    taskflow.Taches.id,
    taskflow.Taches.id_utilisateur,
    taskflow.Taches.titre,
    taskflow.Taches.detail,
    taskflow.Taches.echeance,
    taskflow.Intitules.libelle,
    taskflow.Intitules.couleur,
    taskflow.Intitules.libelle,
    taskflow.Intitules.couleur;