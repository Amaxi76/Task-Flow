-- Insérer 5 jetons
INSERT INTO taskflow.Jetons (jeton, expiration) VALUES
('e3c22770b8f0406f8239b7b50b5fcd0b', '2024-12-10 12:00:00'),
('b9fda91a3c404d88a9a54181bc28dc57', '2024-12-15 12:00:00'),
('ee519f6a627a4f5aa6b7b0f1c267d8a0', '2024-12-20 12:00:00'),
('32dcefa6cc5c44a49040c9267f94bc24', '2024-12-25 12:00:00'),
('59ef8b5d73474e72be87d13a469e1c98', '2024-12-30 12:00:00');

-- Insérer 5 utilisateurs (Personnes)
INSERT INTO taskflow.Personnes (email, nom, mdp) VALUES
('user1@example.com', 'NomUser1', md5('password1')),
('user2@example.com', 'NomUser2', md5('password2')),
('user3@example.com', 'NomUser3', md5('password3')),
('user4@example.com', 'NomUser4', md5('password4')),
('user5@example.com', 'NomUser5', md5('password5'));

-- Associer chaque utilisateur à un jeton (Inscriptions)
INSERT INTO taskflow.Inscriptions (id_personne, id_jeton) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Insérer 5 utilisateurs dans la table Utilisateurs
INSERT INTO taskflow.Utilisateurs (id_personne, id_jeton) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Insérer 10 intitulés pour les statuts et priorités
INSERT INTO taskflow.Intitule (libelle, couleur) VALUES
('En attente', 16711680), -- Rouge
('En cours', 65280),     -- Vert
('Terminé', 255),        -- Bleu
('Haute', 16711680),     -- Rouge
('Moyenne', 16776960),   -- Jaune
('Basse', 65280),
('Bloqué', 8421504),     -- Gris
('Annulé', 0),           -- Noir
('Urgente', 16711935),   -- Magenta
('Faible', 16776960);    -- Jaune pâle

-- Associer chaque utilisateur à des statuts
INSERT INTO taskflow.StatutUtilisateur (id_statut, id_utilisateur, estModifiable) VALUES
(1, 1, TRUE),
(2, 1, TRUE),
(3, 2, TRUE),
(4, 3, TRUE),
(5, 4, TRUE);

-- Associer chaque utilisateur à des priorités
INSERT INTO taskflow.PrioriteUtilisateur (id_priorite, id_utilisateur, estModifiable) VALUES
(6, 1, TRUE),
(7, 2, TRUE),
(8, 3, TRUE),
(9, 4, TRUE),
(10, 5, TRUE);

-- Insérer entre 5 et 20 tâches pour chaque utilisateur
INSERT INTO taskflow.Taches (id_utilisateur, titre, detail, rappel, echeance, id_priorite, id_statut) VALUES
(1, 'Tâche 1_1', 'Détails de la tâche 1', 2, '2024-12-05 12:00:00', 6, 1),
(1, 'Tâche 2_1', 'Détails de la tâche 2', 3, '2024-12-06 12:00:00', 6, 1),
(1, 'Tâche 3_1', 'Détails de la tâche 3', 1, '2024-12-07 12:00:00', 6, 2),
(1, 'Tâche 4_1', 'Détails de la tâche 4', 0, '2024-12-10 12:00:00', 6, 3),
(1, 'Tâche 5_1', 'Détails de la tâche 5', 4, '2024-12-11 12:00:00', 6, 2),
(1, 'Tâche 6_1', 'Détails de la tâche 6', 2, '2024-12-12 12:00:00', 6, 1),
(1, 'Tâche 7_1', 'Détails de la tâche 7', 5, '2024-12-15 12:00:00', 6, 2),
(1, 'Tâche 8_1', 'Détails de la tâche 8', 2, '2024-12-16 12:00:00', 6, 3),
(1, 'Tâche 9_1', 'Détails de la tâche 9', 3, '2024-12-17 12:00:00', 6, 1),
(1, 'Tâche 10_1', 'Détails de la tâche 10', 1, '2024-12-20 12:00:00', 6, 4),

(2, 'Tâche 12_2', 'Détails de la tâche 12', 0, '2024-12-22 12:00:00', 7, 2),
(2, 'Tâche 10_2', 'Détails de la tâche 10', 1, '2024-12-20 12:00:00', 7, 4),
(2, 'Tâche 11_2', 'Détails de la tâche 11', 2, '2024-12-21 12:00:00', 7, 5),

(3, 'Tâche 13_3', 'Détails de la tâche 13', 4, '2024-12-25 12:00:00', 8, 3),
(3, 'Tâche 14_3', 'Détails de la tâche 14', 1, '2024-12-26 12:00:00', 8, 1),
(3, 'Tâche 15_3', 'Détails de la tâche 15', 3, '2024-12-27 12:00:00', 8, 4),
(3, 'Tâche 16_3', 'Détails de la tâche 16', 2, '2024-12-30 12:00:00', 8, 5),
(3, 'Tâche 17_3', 'Détails de la tâche 17', 0, '2024-12-31 12:00:00', 8, 2),

(4, 'Tâche 18_4', 'Détails de la tâche 18', 5, '2025-01-05 12:00:00', 9, 3),
(4, 'Tâche 19_4', 'Détails de la tâche 19', 2, '2025-01-06 12:00:00', 9, 1),
(4, 'Tâche 20_4', 'Détails de la tâche 20', 3, '2025-01-07 12:00:00', 9, 4),
(4, 'Tâche 21_4', 'Détails de la tâche 21', 1, '2025-01-10 12:00:00', 9, 5),
(4, 'Tâche 22_4', 'Détails de la tâche 22', 0, '2025-01-11 12:00:00', 9, 2),

(5, 'Tâche 23_5', 'Détails de la tâche 23', 4, '2025-01-15 12:00:00', 10, 3),
(5, 'Tâche 24_5', 'Détails de la tâche 24', 1, '2025-01-16 12:00:00', 10, 1);

-- Insérer des commentaires pour certaines tâches
INSERT INTO taskflow.Commentaires (id_tache, commentaire) VALUES
(1, 'Commentaire pour la tâche 1'),
(2, 'Commentaire pour la tâche 2'),
(5, 'Commentaire pour la tâche 5'),
(10, 'Commentaire pour la tâche 10'),
(14, 'Commentaire pour la tâche 14');
