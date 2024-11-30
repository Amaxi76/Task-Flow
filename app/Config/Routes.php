<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Route par défaut
$routes->get('/', 'ConnexionControleur::index');

//Inscription et activation du compte
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

// Filtrage
$routes->get ('/taches/filtres/editer', 'TriageFiltrageControleur::index' );
$routes->post('/taches/filtres/appliquer' , 'TriageFiltrageControleur::appliquer'  );

$routes->group('', ['filter' => 'auth'], function ($routes) 
{
    $routes->get ('/personnes'     , 'PersonneControleur::index'); // Page des personnes

	// Tâches
	$routes->get ('/taches/toutes'        , 'TachesControleur::index/toutes'  ); // Page des tâches toutes
	$routes->get ('/taches/kanban'        , 'TachesControleur::index/kanban'  ); // Page des tâches karban


	$routes->get ('/taches/ajouter', 'TachesControleur::ajouter');
	$routes->post('/taches/appliquerAjout', 'TachesControleur::appliquerAjout');

	$routes->post('/taches/modifier', 'TachesControleur::modifier');
	$routes->post('/taches/appliquerModification', 'TachesControleur::appliquerModification');

	$routes->post('/taches/supprimer', 'TachesControleur::appliquerSuppression');
	$routes->post('/taches/appliquerSuppression', 'TachesControleur::appliquerSuppression');

	$routes->post ('/taches/detail','CommentairesControleur::index');

});