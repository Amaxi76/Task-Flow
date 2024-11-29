-- Insertion d'un utilisateur
INSERT INTO taskflow.Personnes (email, nom, mdp) 
VALUES ('antunes.celia2004@gmail.com', 'Celia Antunes', 'motdepasse123');

-- Ajout de l'utilisateur dans la table Utilisateurs
INSERT INTO taskflow.Utilisateurs (id_personne)
SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com';

-- Insertion des intitulés de base
INSERT INTO taskflow.Intitules (id_utilisateur, type_intitule, libelle, couleur) 
VALUES 
((SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com'), 'priorite', 'Urgent', '#FF0000'),
((SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com'), 'priorite', 'Normal', '#00FF00'),
((SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com'), 'statut', 'À faire', '#0000FF'),
((SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com'), 'statut', 'Terminé', '#FFFF00');

-- Insertion de quelques tâches
INSERT INTO taskflow.Taches (id_utilisateur, titre, detail, rappel, echeance, id_priorite, id_statut)
VALUES
((SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com'),
 'Tâche urgente', 'À faire rapidement', 15, NOW() + INTERVAL '1 hour',
 (SELECT id FROM taskflow.Intitules WHERE libelle = 'Urgent' AND id_utilisateur = (SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com')),
 (SELECT id FROM taskflow.Intitules WHERE libelle = 'À faire' AND id_utilisateur = (SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com'))),

((SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com'),
 'Tâche normale', 'À faire plus tard', 30, NOW() + INTERVAL '1 day',
 (SELECT id FROM taskflow.Intitules WHERE libelle = 'Normal' AND id_utilisateur = (SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com')),
 (SELECT id FROM taskflow.Intitules WHERE libelle = 'À faire' AND id_utilisateur = (SELECT id FROM taskflow.Personnes WHERE email = 'antunes.celia2004@gmail.com')));
