<?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Rotas públicas (sem autenticação)
$routes->post('/login','Login::authUser');
$routes->get('/cadastrarusuario','Login::cadUser');
$routes->post('/inserirUsuarios','Home::insertUser');

// Rotas protegidas por autenticação
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/listausuarios','Home::userList');
    $routes->post('/editarUsuario',  'Home::editUser');
    $routes->post('/deleteUser',  'Home::deleteUser');

    $routes->get('/carteira', 'CarteiraController::index');
    $routes->post('carteira/transacao', 'CarteiraController::realizarTransacao');
    $routes->post('carteira/reverter/(:num)', 'CarteiraController::reverter/$1');
    $routes->get('carteira/reverter/(:num)', 'CarteiraController::reverter/$1');
});
