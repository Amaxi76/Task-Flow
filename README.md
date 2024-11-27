# Task-Flow

## Prérequis

### PHP

- Version requise : PHP 8.1
    Vérifier : `php -v`

### Configurations

1. Chercher le fichier php.ini : `php --ini`
2. Ouvrir le fichier et décommenter :

    **(activer les extensions)**
    - `extension_dir = "ext"`

    **(activer php spark)**
    - `extension=intl`
    - `extension=mbstring`

    **(activer psql)**
    - `extension=pdo_pgsql`
    - `extension=pgsql`

    **(activer envoi mail)**
    - `extension=openssl`
