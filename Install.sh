#!/bin/bash

chmod -R 777 writable/

# --------------------------------------------------------------------
# Script d'installation pour configurer le fichier .env
# --------------------------------------------------------------------

# Vérification de l'existence du fichier modèle
if [[ ! -f env ]]; then
    echo "Erreur : Le fichier modèle 'env' est introuvable."
    exit 1
fi

# Copie du fichier modèle vers .env
cp env .env
echo "Le fichier modèle 'env' a été copié en '.env'."

# Fonction pour remplacer un champ dans le fichier .env
remplacer_champ () {
    local champ=$1
    local valeur=$2
    local sedcmd="s|$champ|$valeur|g"
    if [[ "$OSTYPE" == "darwin"* ]]; then
        sed -i '' "$sedcmd" ".env"
    else
        sed -i "$sedcmd" ".env"
    fi
}

# Demande des valeurs à l'utilisateur
read -p "Chemin du serveur (par ex. 'http://localhost:8080 ou http://localhost/Task-Flow/public/'): " chemin_serveur
read -p "Adresse de la base de données (par ex. '127.0.0.1'): " adresse_db
read -p "Nom de la base de données : " nom_db
read -p "Nom d'utilisateur de la base de données : " utilisateur_db
read -s -p "Mot de passe de l'utilisateur de la base de données : " mdp_db
echo
read -p "Driver de la base de données (par ex. 'Postgre'): " driver_db
read -p "Port de la base de données (par ex. '3306'): " port_db
echo
read -p "Email de l'application : " utilisateur_mail
read -p "Mot de passe : " mdp_mail

# Remplacement des champs dans le fichier .env
remplacer_champ "CHEMIN_SERVEUR" "$chemin_serveur"
remplacer_champ "ADRESSE_DB" "$adresse_db"
remplacer_champ "NOM_DB" "$nom_db"
remplacer_champ "NOM_UTILISATEUR" "$utilisateur_db"
remplacer_champ "MDP_UTILISATEUR" "$mdp_db"
remplacer_champ "NOM_DRIVER" "$driver_db"
remplacer_champ "NUMERO_PORT" "$port_db"
remplacer_champ "ADRESSE_MAIL" "$utilisateur_mail"
remplacer_champ "TOKEN_MAIL" "$mdp_mail"

echo "La configuration du fichier '.env' est terminée avec succès."
