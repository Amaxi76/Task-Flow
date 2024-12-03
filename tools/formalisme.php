<?php

namespace Formalisme;

class ExempleFormalisme {
    private static array $tab;

    private Controleur $ctrl;
    
    private Panel $pnl1;
    private Panel $pnl2;
    private Button $btn;

    private string $arg2;
    private int $arg;
    private int $arg3;

    public function __construct(int $arg) {
        // Tous les cas qui sont faux
        if ($test === true) {
            return;
        }

        // Code à exécuter si les tests sont réussis
    }

    /*---------------------------------------*/
    /*                GETTEUR                */
    /*---------------------------------------*/

    private function getArg(): int { return $this->arg; }
    private function getArg2(): int { return $this->arg; }

    
    /*---------------------------------------*/
    /*                SETTEUR                */
    /*---------------------------------------*/

    private function setArg(int $valeur): void { $this->arg = $valeur; }


    /*---------------------------------------*/
    /*                TESTEUR                */
    /*---------------------------------------*/

    private function estArg(): bool { return $this->arg === $arg; }

    // On ne retourne pas le metier, on fait le lien dans le controleur
    private function estMetier(): bool { return $this->metier->test(); }


    /*---------------------------------------*/
    /*                METHODES               */
    /*---------------------------------------*/ 

    public function __toString(): string {
        $sRet = "";

        $sRet = sprintf("Nom : %-20s - ", $this->nom) .
                sprintf("Heure Service Contrat : %02d - ", $this->heureServiceContrat) .
                sprintf("Heure Max Contrat : %02d - ", $this->heureMaxContrat) .
                sprintf("Ratio TP : %,.2f", $this->ratioTP);

        return $sRet;
    }

    /**
     * Calcule le produit de deux nombres
     *
     * @param float $a Premier nombre à multiplier
     * @param float $b Deuxième nombre à multiplier
     * @return float Le produit des deux nombres
     */
    private function jeSaisPasMoi(): int { 
        /* Méthode importante */
        return $this->arg; 
    }
}

/*
 * Fonction n'a qu'un seul rôle
 * Bien nommer les variables
 * Bien nommer les fonctions explicitement
 * Diviser en plein de petites fonctions
 * Diviser en plein de conditions les if important (variables intermédiaires)
 * Ordre d'appel des fonctions
 * Fonction réutilisable au maximum
 * Faire des branches sur git par fonctionalité, avec des commits explicites
 * Branche dev et main
 */

/* Fonction n'a qu'un seul rôle
 * Bien nommer les variables
 * Bien nommer les fonctions explicitement
 * Diviser en plein de petites fonctions
 * Diviser en plein de conditions les if important (variables intermédiaires)
 * Ordre d'appel des fonctions
 * Fonction réutilisable au maximum
 * Faire des branches sur git par fonctionalité, avec des commits explicites
 * Branche dev et main
 */

 /*
  * Modèle     : MainModele.php     (/Models/MainModele.php)
  * Controleur : MainControleur.php (/Controllers/MainControleur.php)
  * Vue        : mainVue.php        (/Views/mainVue.php)
  */