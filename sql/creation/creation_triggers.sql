-- TODO: à ne pas utiliser par la suite je pense pour que ça soit plus clair
-- (on mettrait plutot les insertions )

CREATE FUNCTION taskflow.insererIntitulesNouveauUtilisateur() RETURNS TRIGGER AS
    $$
    BEGIN
        INSERT INTO taskflow.Intitules (id_utilisateur, type_intitule, libelle, couleur, est_supprimable)
        VALUES
            (NEW.id_personne, 'statut', 'En attente', '#B9B9B9', FALSE),
            (NEW.id_personne, 'statut', 'En cours', '#FFB973', FALSE),
            (NEW.id_personne, 'statut', 'Terminé', '#00B94D', FALSE);

        INSERT INTO taskflow.Intitules (id_utilisateur, type_intitule, libelle, est_supprimable)
        VALUES
            (NEW.id_personne, 'priorite', 'Haute', FALSE),
            (NEW.id_personne, 'priorite', 'Moyenne', FALSE),
            (NEW.id_personne, 'priorite', 'Basse', FALSE);

        RETURN NEW;
    END;
    $$
LANGUAGE plpgsql;

CREATE TRIGGER trigger_insererIntitulesNouveauUtilisateur
    AFTER INSERT ON taskflow.Utilisateurs
    FOR EACH ROW
        EXECUTE FUNCTION taskflow.insererIntitulesNouveauUtilisateur();



-- Trigger pour vérifer que les intitules inseres dans les taches correspondent bien à ceux de l'utilisateur et au type attendu

CREATE FUNCTION taskflow.verifierIntitulesTache() RETURNS TRIGGER AS
    $$
    BEGIN
        IF (SELECT COUNT(*) FROM taskflow.Intitules WHERE id = NEW.id_statut AND id_utilisateur = NEW.id_utilisateur AND type_intitule = 'statut') = 0 THEN
            RAISE EXCEPTION 'L''intitulé de statut de la tâche ne correspond pas à un intitulé de statut de l''utilisateur';
        END IF;

        IF (SELECT COUNT(*) FROM taskflow.Intitules WHERE id = NEW.id_priorite AND id_utilisateur = NEW.id_utilisateur AND type_intitule = 'priorite') = 0 THEN
            RAISE EXCEPTION 'L''intitulé de priorité de la tâche ne correspond pas à un intitulé de priorité de l''utilisateur';
        END IF;

        RETURN NEW;
    END;
    $$
LANGUAGE plpgsql;

CREATE TRIGGER trigger_verifierIntitulesTache
    BEFORE INSERT OR UPDATE ON taskflow.Taches
    FOR EACH ROW
        EXECUTE FUNCTION taskflow.verifierIntitulesTache();