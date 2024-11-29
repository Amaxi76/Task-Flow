SELECT 
    t.titre AS titre,
    t.detail AS detail,
    t.date_echeance AS echeance,
    i_statut.libelle AS statut,
    i_priorite.libelle AS priorite
FROM 
    taskflow.Taches t
INNER JOIN 
    taskflow.Intitule i_statut ON t.id_statut = i_statut.id_intitule
INNER JOIN 
    taskflow.Intitule i_priorite ON t.id_priorite = i_priorite.id_intitule
GROUP BY 
    t.id, i_statut.libelle, i_priorite.libelle;
