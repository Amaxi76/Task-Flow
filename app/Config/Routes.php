<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Route par défaut


//Inscription et activation du compte
$routes->get ('/inscription'                         ,'InscriptionControleur::index'                );
$routes->post('/inscription'                         ,'InscriptionControleur::inscription'          );
$routes->get ('/inscription/activationCompte/(:any)' ,'ActivationCompteControleur::index/$1'        );
$routes->get ('/inscription/mailenvoye'              ,'InscriptionControleur::afficherMailEnvoye'   );
$routes->post ('/inscription/renvoieMail'            ,'InscriptionControleur::resetProcedure'    );


// Connexion et mot de passe oublié
$routes->get ('/connexion'                             ,'ConnexionControleur::index'                                );
$routes->post('/connexion'                             ,'ConnexionControleur::connexion'                            );
$routes->get ('/connexion/mdp_oublie'                  ,'ConnexionControleur::afficherFormulaireEnvoieMail'         );
$routes->post('/connexion/mdp_oublie/envoie_mail'      ,'ConnexionControleur::envoiMailMdpOublie'                   );
$routes->get ('/connexion/mdp_oublie/reinit_mdp/(:any)','ReinitialisationMotDePasseControleur::index/$1'            );
$routes->post('/connexion/mdp_oublie/reinit_mdp'       ,'ReinitialisationMotDePasseControleur::changementMotDePasse');

// Déconnexion
$routes->get('/deconnexion','ConnexionControleur::deconnexion');

$routes->group('', ['filter' => 'auth'], function ($routes) 
{
    $routes->get('/', 'TachesControleur::index');
    $routes->get ('/personnes'     , 'PersonneControleur::index'); // Page des personnes
    $routes->get ('/taches'        , 'TachesControleur::index'  ); // Page des tâches
    $routes->get ('/taches/ajouter', 'TachesControleur::ajouter'); // Ajouter une tâche
    $routes->post('/taches/stocker', 'TachesControleur::stocker'); // Insérer une tâche
});
