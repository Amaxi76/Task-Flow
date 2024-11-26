<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/','PersonneControleur::index');
$routes->get('/personnes','PersonneControleur::index');
$routes->get('/taches','TachesControleur::index');

$routes->get('/taches/ajouter','TachesControleur::ajouter');
$routes->post('/taches/inserer','TachesControleur::ajouter');


