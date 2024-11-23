<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use App\Core\Application;
use App\Core\Router;

$app = new Application();
$router = new Router();

// Define routes
$router->get('/', 'HomeController@index');
$router->get('/form', 'FormController@show');
$router->post('/form', 'FormController@store');
$router->get('/payment', 'PaymentController@show');
$router->post('/payment', 'PaymentController@process');
$router->get('/success', 'HomeController@success');

$router->get('/admin/login', 'AdminController@login');
$router->post('/admin/login', 'AdminController@authenticate');
$router->get('/admin/registrations', 'AdminController@registrations');
$router->get('/admin/logout', 'AdminController@logout');

// Add these new routes
$router->get('/payment/{id}/{token}', 'PaymentController@verify');
$router->post('/payment/process', 'PaymentController@process');

$router->post('/payment/create-session', 'PaymentController@createSession');
$router->get('/payment/success', 'PaymentController@success');
$router->get('/payment/cancel', 'PaymentController@cancel');

$app->run($router);
