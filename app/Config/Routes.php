<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/','PersonneControleur::index');
$routes->get('/test','PersonneControleur::index');



