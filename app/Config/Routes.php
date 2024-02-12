<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');


/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');


// Créer ou mettre à jour un compte utilisateur
$routes->get('/comptes/(:num)?', 'Comptes::createOrUpdateCompte/$1', ['filter' => 'AdminCheck'], 'createOrUpdateCompte');

// afficher les comptes utilisateur
$routes->get('/comptes', 'Comptes::comptes', ['filter' => 'AdminCheck']);

// tous les utilisateurs
$routes->get('/users', 'Users::all_users', ['filter' => 'AdminCheck']);

// routes pour l'utilisateur lambda
$routes->get('/user', 'User::index', ['filter' => 'AuthCheck']);
$routes->get('/user/user_confirmation', 'User::user_confirmation', ['filter' => 'AuthCheck']);
$routes->post('/user/save_data', 'User::save_data', ['filter' => 'AuthCheck']);
// ************************************************
// Ajouter les routes ici
// ajouter toutes les routes protégées par ce filter
$routes->get('/auth', 'Auth::index', ['filter' => 'AlreadyLoggedIn']);
$routes->get('/auth/register', 'Auth::register', ['filter' => 'AlreadyLoggedIn']);
// ************************************************

$routes->set404Override(static function () {
    echo view('errors/404.php');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
