<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Rutas de la aplicación.
 * 29-Octubre-2026 |26-Septiembre-2026
 * 
 */

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

service('auth')->routes($routes);

$routes->get('/', 'Home::index');

$routes->group('', ['filter' => ['session', 'group:admin,user']], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index', ['as' => 'dashboard']);
    $routes->get('profile', 'ProfileController::index', ['as' => 'profile']);
    $routes->get('users', 'UsersController::index', ['as' => 'users']);
    $routes->get('tickets', 'TicketsController::index', ['as' => 'tickets']);
});

$routes->group('profile', ['filter' => ['session', 'group:admin,user']], function ($routes) {
    $routes->post('update-password', 'ProfileController::changePassword');
    $routes->post('update-email', 'ProfileController::updateEmail');
    $routes->post('update-profile', 'ProfileController::updateProfile');
});