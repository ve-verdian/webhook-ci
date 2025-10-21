<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'Dashboard::index');
// $routes->get('webhook/incoming', 'Webhook::index'); // optional untuk test di browser
// $routes->get('messages', 'MessageController::index');
$routes->match(['get', 'post'], 'webhook/incoming', 'Webhook::index');
$routes->match(['get', 'post'], 'webhook/status', 'MessageController::index');
$routes->match(['get', 'post'], 'webhook/device-status', 'Webhook::deviceStatus');


