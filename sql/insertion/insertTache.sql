-- Insérer des utilisateurs (sans email rempli)
INSERT INTO taskflow.Personnes (email, nom, mdp) VALUES
('thomasboudeele1@gmail.com', 'Thomas 2', '12345'),
('thomasboudeele3@gmail.com', 'Thomas 2', '12345');


INSERT INTO taskflow.Utilisateurs (id_personne) VALUES
(1),
(2);


-- Insérer des tâches avec des échéances commençant dans 10 minutes
INSERT INTO taskflow.Taches (id_utilisateur, titre, detail, echeance, rappel, id_priorite, id_statut) VALUES
(1,'taches thomas 1 +1  min','detail',now() + INTERVAL '30 minutes',29,2,1),
(1,'taches thomas 1 +5  min','detail',now() + INTERVAL '30 minutes',25,2,1),
(1,'taches thomas 1 +10 min','detail',now() + INTERVAL '30 minutes',20,2,1),
(1,'taches thomas 1 +15 min','detail',now() + INTERVAL '30 minutes',15,2,1),
(2,'taches thomas 2 +1  min','detail',now() + INTERVAL '30 minutes',29,2,1),
(2,'taches thomas 2 +5  min','detail',now() + INTERVAL '30 minutes',25,2,1),
(2,'taches thomas 2 +10 min','detail',now() + INTERVAL '30 minutes',20,2,1),
(2,'taches thomas 2 +15 min','detail',now() + INTERVAL '30 minutes',15,2,1);

