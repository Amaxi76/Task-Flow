# Task-Flow

## Prérequis

### PHP

- Version requise : PHP 8.1
  Vérifier : `php -v`

### PostgreSQL

- Version requise : PostgreSQL 15.10
  Vérifier : `psql --version`

### Récupération du projet

Vous pouvez récupérer le projet en clonant le répertoire GitHub avec la commande suivante dans votre terminal :

```bash
git clone git@github.com:Amaxi76/Task-Flow.git
```
Alternativement, vous pouvez télécharger le projet au format .zip depuis :

`https://github.com/Amaxi76/Task-Flow`


## Configurations

1. Localisez le fichier php.ini : `php --ini`
2. Ouvrir le fichier et décommentez les lignes suivantes :

    **(pour activer les extensions)**
    - `extension_dir = "ext"`

    **(pour activer php spark)**
    - `extension=intl`
    - `extension=mbstring`

    **(pour activer psql)**
    - `extension=pdo_pgsql`
    - `extension=pgsql`

    **(pour activer l'envoi de mails)**
    - `extension=openssl`
    - `extension=curl`

3. Exécutez le script `Install.sh` pour configurer le `.env`

### Lancement du serveur 

1. Démarrez le serveur web avce la commande appropriée: 
    
    **Pour Linux ou MacOS**
    ```shell 
    ./run_spark_cron.sh
    ```

    **Pour Windows** 
    ```shell 
    run_xampp_cron.bat
    ```

2. Rentrez l'URL renseigné dans le `.env` (par défaut `http://localhost/Task-Flow/public`)
