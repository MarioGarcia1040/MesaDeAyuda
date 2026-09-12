<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

service('auth')->routes($routes);

$routes->get('/', 'Home::index');

$routes->group('', ['filter' => 'group:admin,user'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index', ['as' => 'dashboard']);
    $routes->get('profile', 'ProfileController::index', ['as' => 'profile']);
    $routes->get('settings', 'SettingsController::index', ['as' => 'settings']);
});