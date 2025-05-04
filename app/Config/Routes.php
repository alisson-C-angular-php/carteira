<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


//auth
$routes->post('/login','Login::authUser');



//crud

$routes->get('/listausuarios','Home::userList');

$routes->post('/inserirUsuarios','Home::insertUser');


$routes->post('/editarUsuario',  'Home::editUser');

$routes->post('/deleteUser',  'Home::deleteUser');