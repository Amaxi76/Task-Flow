<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Inscription et activation du compte
$routes->get ('/inscription'                         ,'InscriptionControleur::index'        );
$routes->post('/inscription'                         ,'InscriptionControleur::inscription'  );
$routes->get ('/inscription/activationCompte/(:any)' ,'ActivationCompteControleur::index/$1');

// Connexion et mot de passe oublié
$routes->get ('/connexion'                             ,'ConnexionControleur::index'                                );
$routes->post('/connexion'                             ,'ConnexionControleur::connexion'                            );
$routes->get ('/connexion/mdp_oublie'                  ,'ConnexionControleur::afficherFormulaireEnvoieMail'         );
$routes->post('/connexion/mdp_oublie/envoie_mail'      ,'ConnexionControleur::envoiMailMdpOublie'                   );
$routes->get ('/connexion/mdp_oublie/reinit_mdp/(:any)','ReinitialisationMotDePasseControleur::index/$1'            );
$routes->post('/connexion/mdp_oublie/reinit_mdp'       ,'ReinitialisationMotDePasseControleur::changementMotDePasse');

// Déconnexion
$routes->get('/deconnexion','ConnexionControleur::deconnexion');

// Routes non protégées
$routes->get('/','PersonneControleur::index');
$routes->get('/test','TachesControleur::test');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/personnes', 'PersonneControleur::index');       // Page des personnes
    $routes->get('/taches', 'TachesControleur::index');           // Page des tâches
    $routes->get('/taches/ajouter', 'TachesControleur::ajouter'); // Ajouter une tâche
    $routes->post('/taches/inserer', 'TachesControleur::ajouter'); // Insérer une tâche
});
