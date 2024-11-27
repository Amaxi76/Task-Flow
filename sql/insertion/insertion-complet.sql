-- Insérer des jetons
INSERT INTO taskflow.Jetons (jeton, expiration)
VALUES
    ('abc123', NOW() + INTERVAL '7 days'),
    ('xyz456', NOW() + INTERVAL '30 days');

-- Insérer des personnes
INSERT INTO taskflow.Personnes (email, nom, mdp)
VALUES
    ('johndoe@example.com', 'John Doe', 'password123'),
    ('janedoe@example.com', 'Jane Doe', 'securepass');

-- Insérer des inscriptions
INSERT INTO taskflow.Inscriptions (id_personne, id_jeton)
VALUES
    (1, 1), -- John Doe avec le jeton 1
    (2, 2); -- Jane Doe avec le jeton 2

-- Insérer des utilisateurs
INSERT INTO taskflow.Utilisateurs (id_personne, id_jeton)
VALUES
    (1, 1), -- John Doe
    (2, 2); -- Jane Doe

-- Insérer des intitulés pour statuts et priorités
INSERT INTO taskflow.Intitule (libelle, couleur)
VALUES
    ('En attente', 16711680), -- Rouge
    ('En cours', 65280),     -- Vert
    ('Terminé', 255),        -- Bleu
    ('Haute', 16711680),   -- Rouge
    ('Moyenne', 16776960), -- Jaune
    ('Basse', 65280);      -- Vert

-- Insérer des statuts pour utilisateurs
INSERT INTO taskflow.StatutUtilisateur (id_statut, id_utilisateur, est_modifiable)
VALUES
    (1, 1, TRUE), -- John Doe - En attente
    (2, 2, FALSE); -- Jane Doe - En cours

-- Insérer des priorités pour utilisateurs
INSERT INTO taskflow.PrioriteUtilisateur (id_priorite, id_utilisateur, est_modifiable)
VALUES
    (4, 1, TRUE), -- John Doe - Haute
    (5, 2, TRUE); -- Jane Doe - Moyenne

-- Insérer des tâches
INSERT INTO taskflow.Taches (id_utilisateur, titre, detail, rappel, echeance, id_priorite, id_statut)
VALUES
    (1, 'Acheter des fournitures', 'Papeterie et stylos', 3, NOW() + INTERVAL '3 days', 4, 1), -- John Doe
    (2, 'Préparer la réunion', 'Diapositives et agenda', NULL, NOW() + INTERVAL '2 days', 5, 2); -- Jane Doe

-- Insérer des commentaires
INSERT INTO taskflow.Commentaires (id_tache, commentaire)
VALUES
    (1, 'Vérifier les prix en ligne avant d’acheter.'),
    (2, 'Ajouter une section sur les points en suspens.');
