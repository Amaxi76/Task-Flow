SELECT p.id AS ID, p.email AS EMAIL, p.nom AS NOM, p.mdp AS MDP, j.id AS ID_JETON, j.expiration AS EXP_JETON, u.id_jeton_resetMdp AS RESET_JETON, u.id_jeton_seSouvenir AS SOUVENIR_JETON
FROM taskflow.Personnes p
JOIN taskflow.Inscriptions i ON p.id = i.id_personne
JOIN taskflow.Utilisateurs u ON p.id = u.id_personne
JOIN taskflow.Jetons j ON i.id_jeton = j.id;
