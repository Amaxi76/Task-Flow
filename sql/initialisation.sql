/* Insertion par défaut des priorités et des statuts */

-- Insertion des priorités dans la table Intitule
INSERT INTO taskflow.Intitule (libelle, couleur) VALUES
('Urgent'   , 1),
('Important', 2),
('Modéré'   , 3),
('Faible'   , 4);

-- Insertion des statuts dans la table Intitule
INSERT INTO taskflow.Intitule (libelle, couleur) VALUES
('En cours'  , 5),
('Terminé'   , 6),
('En attente', 7);
