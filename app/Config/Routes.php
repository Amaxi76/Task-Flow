<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('/connexion/mdp_oublie'                  ,'ConnexionControleur::afficherFormulaireEnvoieMail'         );
$routes->get ('/connexion/mdp_oublie'                  ,'ConnexionControleur::afficherFormulaireEnvoieMail'         );
$routes->post('/connexion/mdp_oublie/envoie_mail'      ,'ConnexionControleur::envoiMailMdpOublie'                   );
$routes->get ('/connexion/mdp_oublie/reinit_mdp/(:any)','ReinitialisationMotDePasseControleur::index/$1'            );
$routes->post('/connexion/mdp_oublie/reinit_mdp'       ,'ReinitialisationMotDePasseControleur::changementMotDePasse');

$routes->post('/cron/run', 'Cron::lancerTaches');

$routes->group('', ['filter' => 'unAuth'], function($routes) 
{
	//Inscription et activation du compte
	$routes->get ('/inscription'                         ,'InscriptionControleur::index'                );
	$routes->post('/inscription'                         ,'InscriptionControleur::inscription'          );
	$routes->get ('/inscription/activationCompte/(:any)' ,'ActivationCompteControleur::index/$1'        );
	$routes->get ('/inscription/mailenvoye'              ,'InscriptionControleur::afficherMailEnvoye'   );
	$routes->post('/inscription/renvoieMail'             ,'InscriptionControleur::resetProcedure'       );
	$routes->get ('/inscription/jeton_expire'            ,'InscriptionControleur::jetonExpire'          );

	// Connexion et mot de passe oublié
	$routes->get ('/connexion'                             ,'ConnexionControleur::index'                                );
	$routes->post('/connexion'                             ,'ConnexionControleur::connexion'                            );
});


$routes->group('', ['filter' => 'auth'], function ($routes)
{
	// Tâches
	$routes->get ('/','TachesControleur::index/'); // Page d'accueil
	$routes->get ('/taches','TachesControleur::index/');

	// Configurations affichage taches
	$routes->post ( '/taches/setNbTacheParPage', 'TachesControleur::changerNbTachesParPage');
	$routes->get  ( '/taches/vue/(:any)','TachesControleur::changerTypeVue/$1');

	// CRUD taches
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
	$routes->get  ('/taches/detail','CommentairesControleur::index');
	$routes->post ('/commentaires/appliquerAjout','CommentairesControleur::appliquerAjout');
	$routes->post ('/commentaires/appliquerSuppression','CommentairesControleur::appliquerSuppression');

	//TODO: mettre les pages du profil dans le groupe qui vérifie l'authentification
	$routes->get ('/profil'                 , 'ProfilControleur::index'   );
	$routes->post ('/profil/changementMdp'   , 'ProfilControleur::formulaireChangementMdp' );
	$routes->post('/profil/appliquerChangementMdp', 'ProfilControleur::changementMotDePasse');
	$routes->post('profil/enregistrer-modif', 'ProfilControleur::enregistrerCouleurs');
	$routes->post('profil/supprimer-compte'    , 'ProfilControleur::supprimerCompte');
	$routes->post('profil/ajouter-statut'    , 'ProfilControleur::ajouterStatut');
	$routes->get ('profil/supprimer-statut/(:any)'    , 'ProfilControleur::supprimerStatut/$1'); //TODO: ça serait mieux avec POST

	// Déconnexion
	$routes->get('/deconnexion','ConnexionControleur::deconnexion');
});

