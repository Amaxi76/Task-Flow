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

-- Insérer des status personnalisés pour chaque utilisateur
INSERT INTO taskflow.Intitules (id_utilisateur, type_intitule, libelle, couleur) VALUES
(1, 'statut', 'Statut perso', '#374374');

-- Insérer entre 5 et 20 tâches pour chaque utilisateur
INSERT INTO taskflow.Taches (id_utilisateur, titre, detail, rappel, echeance, id_priorite, id_statut) VALUES
(1, 'Tâche 1_1', 'Détails de la tâche 1', 2, '2024-12-05 12:00:00', 4, 1),
(1, 'Tâche 2_1', 'Détails de la tâche 2', 3, '2024-12-06 12:00:00', 4, 1),
(1, 'Tâche 3_1', 'Détails de la tâche 3', 1, '2024-12-07 12:00:00', 4, 2),
(1, 'Tâche 4_1', 'Détails de la tâche 4', 0, '2024-12-10 12:00:00', 4, 3),
(1, 'Tâche 5_1', 'Détails de la tâche 5', 4, '2024-12-11 12:00:00', 5, 2),
(1, 'Tâche 6_1', 'Détails de la tâche 6', 2, '2024-12-12 12:00:00', 5, 1),
(1, 'Tâche 7_1', 'Détails de la tâche 7', 5, '2024-12-15 12:00:00', 5, 2),
(1, 'Tâche 8_1', 'Détails de la tâche 8', 2, '2024-12-16 12:00:00', 6, 3),
(1, 'Tâche 9_1', 'Détails de la tâche 9', 3, '2024-12-17 12:00:00', 6, 1),
(1, 'Tâche 10_1', 'Détails de la tâche 10', 1, '2024-12-20 12:00:00', 6, 1),

(2, 'Tâche 12_2', 'Détails de la tâche 12', 0, '2024-12-22 12:00:00', 10, 7),
(2, 'Tâche 10_2', 'Détails de la tâche 10', 1, '2024-12-20 12:00:00', 10, 8),
(2, 'Tâche 11_2', 'Détails de la tâche 11', 2, '2024-12-21 12:00:00', 10, 9),

(3, 'Tâche 13_3', 'Détails de la tâche 13', 4, '2024-12-25 12:00:00', 16, 13),
(3, 'Tâche 14_3', 'Détails de la tâche 14', 1, '2024-12-26 12:00:00', 16, 13),
(3, 'Tâche 15_3', 'Détails de la tâche 15', 3, '2024-12-27 12:00:00', 16, 13),
(3, 'Tâche 16_3', 'Détails de la tâche 16', 2, '2024-12-30 12:00:00', 16, 14),
(3, 'Tâche 17_3', 'Détails de la tâche 17', 0, '2024-12-31 12:00:00', 17, 14),

(4, 'Tâche 18_4', 'Détails de la tâche 18', 5, '2025-01-05 12:00:00', 22, 19),
(4, 'Tâche 19_4', 'Détails de la tâche 19', 2, '2025-01-06 12:00:00', 22, 19),
(4, 'Tâche 20_4', 'Détails de la tâche 20', 3, '2025-01-07 12:00:00', 22, 20),
(4, 'Tâche 21_4', 'Détails de la tâche 21', 1, '2025-01-10 12:00:00', 23, 21),
(4, 'Tâche 22_4', 'Détails de la tâche 22', 0, '2025-01-11 12:00:00', 24, 21),

(5, 'Tâche 23_5', 'Détails de la tâche 23', 4, '2025-01-15 12:00:00', 30, 25),
(5, 'Tâche 24_5', 'Détails de la tâche 24', 1, '2025-01-16 12:00:00', 30, 26);

-- Insérer des commentaires pour certaines tâches
INSERT INTO taskflow.Commentaires (id_tache, commentaire) VALUES
(1, 'Commentaire pour la tâche 1'),
(2, 'Commentaire pour la tâche 2'),
(5, 'Commentaire pour la tâche 5'),
(10, 'Commentaire pour la tâche 10'),
(14, 'Commentaire pour la tâche 14');
