<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/login','Login::authUser');
$routes->get('/cadastrarusuario','Login::cadUser');
$routes->post('/inserirUsuarios','Home::insertUser');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/listausuarios','Home::userList');
    $routes->post('/editarUsuario',  'Home::editUser');
    $routes->post('/deleteUser',  'Home::deleteUser');

    $routes->get('/carteira', 'TransactionController::index');
    $routes->post('carteira/transacao', 'TransactionController::realizarTransacao');
    $routes->post('carteira/reverter/(:num)', 'TransactionController::reverter/$1');
    $routes->get('carteira/reverter/(:num)', 'TransactionController::reverter/$1');
});
