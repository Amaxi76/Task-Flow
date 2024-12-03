<div align="center">
	<img src="./public/assets/images/Task-Flow-Horizontal.svg" alt="Task-Flow Logo" width="300">
</div>

## 🛠️ Prérequis

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

---

## ⚙️ Configurations

### 1. Localisez le fichier php.ini :

commande : `php --ini`

### 2. Ouvrir le fichier et décommentez les lignes suivantes :

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

### 3. Configurer le `.env` contenu dans le projet :

**Pour Linux ou MacOS**
```sh 
chmod u+x Install.sh
./Install.sh
```

**Pour Windows**
- affichez les fichiers cachés puis modifiez le fichier '.env'
- remplacer les mots en majuscules, situés entre les apostrophes, par vos informations
- Exemple : la ligne `database.default.DBDriver = 'NOM_DRIVER'` donnerait `database.default.DBDriver = 'Postgre'`

---

## 🚀 Lancement du serveur 

### 1. Démarrez le serveur web avce la commande appropriée: 

**Pour Linux ou MacOS**

```shell 
./run_spark_cron.sh
```

**Pour Windows** 

```shell 
run_xampp_cron.bat
```

**Pour tous les OS**

- (en version minimale sans les rappels cycliques par mail)
- commande : `php spark serve`

### 2. Saisissez l'URL renseignée dans le `.env` :

par défaut : [http://localhost:8080](http://localhost:8080)

ou : [http://localhost/Task-Flow/public](http://localhost/Task-Flow/public)

---

## 📍 Contributeurs

Projet commencé en novembre 2024 par :

- Célia
- Maxime
- Maximilien
- Thomas
