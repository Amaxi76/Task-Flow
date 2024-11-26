<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get ('/','Home::index');
$routes->get ('/inscription'                      ,'InscriptionControleur::index'        );
$routes->post('InscriptionControleur/inscription' ,'InscriptionControleur::inscription'  );
$routes->get ('activationCompte/(:any)'           ,'ActivationCompteControleur::index/$1');

//Connexion et mot de passe oublié
$routes->get ('/connexion'                   ,'ConnexionControleur::index'                 );
$routes->post('ConnexionControleur/connexion','ConnexionControleur::connexion'             );
$routes->get ('/MotDePasseOublie/formulaireEnvoieMail','ConnexionControleur::afficherFormulaireEnvoieMail');
$routes->post('ConnexionControleur/mdpOublie','ConnexionControleur::envoiMailMdpOublie'    );
$routes->get ('/reinitMdp/(:any)','ReinitialisationMotDePasseControleur::index/$1');
