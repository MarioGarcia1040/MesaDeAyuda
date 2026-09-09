<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);   

service('auth')->routes($routes);
