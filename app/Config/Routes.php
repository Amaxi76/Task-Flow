<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/','Home::index');
$routes->get('/inscription','UtilisateurControleur::index');
$routes->post('UtilisateurControleur/inscription','UtilisateurControleur::inscription');



