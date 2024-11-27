DELETE FROM taskflow.inscriptions
WHERE       id_personne >= 6;

DELETE FROM taskflow.utilisateurs
WHERE       id_personne >= 6;

DELETE FROM taskflow.personnes 
WHERE       id >= 6;