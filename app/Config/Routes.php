<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Index');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

$routes->get('/', 'Index::index');
$routes->match(['get', 'post'],'login', 'Login::index');
$routes->match(['get', 'post'],'register', 'Register::index');
$routes->get('logout','Login::logout');
$routes->post('login/login', 'Login::login');
$routes->post('register/register', 'Register::register');
$routes->get('upload', 'Upload::index', ['filter' => 'authGuard']);
$routes->post('upload/upload', 'Upload::upload', ['filter' => 'authGuard']);
$routes->get('media', 'Media::index', ['filter' => 'authGuard']);
$routes->get('uploads/(:segment)', 'Upload::show/$1', ['filter' => 'authGuard']);
$routes->post('upload/delete/(:num)', 'Upload::delete/$1', ['filter' => 'authGuard']);
$routes->post('upload/update-caption/(:num)', 'Media::updateCaption/$1', ['filter' => 'authGuard']);
$routes->post('upload/update-filename/(:num)', 'Media::updateFilename/$1', ['filter' => 'authGuard']);

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


if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
