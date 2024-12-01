<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

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

$routes->get ('/cron/envoyer_rappels','Cron::envoyerRappelsTaches');

$routes->get('/cron/run', 'Cron::lancerTaches');

// Déconnexion
$routes->get('/deconnexion','ConnexionControleur::deconnexion');


$routes->group('', ['filter' => 'auth'], function ($routes) 
{
	// Routes temporaires avant de changer le type de vue dans la session
	$routes->get ('/','TachesControleur::index/toutes'  ); // Page d'accueil
	$routes->get ('/taches','TachesControleur::index/toutes');

	// Tâches
	$routes->get ('/taches/toutes'        , 'TachesControleur::index/toutes'  ); // Page des tâches toutes
	$routes->get ('/taches/kanban'        , 'TachesControleur::index/kanban'  ); // Page des tâches karban


	$routes->get ('/taches/ajouter', 'TachesControleur::ajouter');
	$routes->post('/taches/appliquerAjout', 'TachesControleur::appliquerAjout');

	$routes->get('/taches/modifier', 'TachesControleur::modifier');
	$routes->post('/taches/modifier', 'TachesControleur::modifier');
	$routes->post('/taches/appliquerModification', 'TachesControleur::appliquerModification');

	$routes->post('/taches/supprimer', 'TachesControleur::appliquerSuppression');

	// Filtrage
	$routes->get ('/taches/filtres/editer', 'TriageFiltrageControleur::index' );
	$routes->post('/taches/filtres/appliquer' , 'TriageFiltrageControleur::appliquer'  );

	// Commentaires
	$routes->post ('/taches/detail','CommentairesControleur::index');
	$routes->get ('/taches/detail','CommentairesControleur::index');
	$routes->post ('/commentaires/appliquerAjout','CommentairesControleur::appliquerAjout');
	$routes->post ('/commentaires/appliquerSuppression','CommentairesControleur::appliquerSuppression');
});

