<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ====================
// RUTE UNTUK TAMU (guest)
// ====================
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'Auth::index');
    $routes->get('register', 'Auth::register');
});

// ====================
// RUTE AKSI PUBLIK (login, logout, dll)
// ====================
$routes->post('login', 'Auth::login');
$routes->post('register', 'Auth::processRegister');
$routes->get('logout', 'Auth::logout');

// ====================
// RUTE WAJIB LOGIN (auth)
// ====================
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');

    $routes->get('akun', 'Akun::index');
    $routes->post('akun/update_profil', 'Akun::updateProfil');
    $routes->post('akun/update_sandi', 'Akun::updateSandi');

    $routes->group('customer', function ($routes) {
        $routes->get('/', 'CustomerController::index');
        $routes->get('create', 'CustomerController::create');
        $routes->post('store', 'CustomerController::store');
        $routes->get('edit/(:num)', 'CustomerController::edit/$1');
        $routes->put('update/(:num)', 'CustomerController::update/$1');
        $routes->delete('delete/(:num)', 'CustomerController::delete/$1');
    });

    $routes->group('petugas', function ($routes) {
        $routes->get('/', 'PetugasController::index');
        $routes->get('create', 'PetugasController::create');
        $routes->post('store', 'PetugasController::store');
        $routes->get('edit/(:num)', 'PetugasController::edit/$1');
        $routes->put('update/(:num)', 'PetugasController::update/$1');
        $routes->delete('delete/(:num)', 'PetugasController::delete/$1');
    });

    $routes->group('tickets', function ($routes) {
        $routes->get('/', 'TicketController::index');
        $routes->get('create', 'TicketController::create');
        $routes->post('store', 'TicketController::store');
        $routes->get('edit/(:num)', 'TicketController::edit/$1');
        $routes->put('update/(:num)', 'TicketController::update/$1');
        $routes->delete('delete/(:num)', 'TicketController::delete/$1');

        $routes->get('getcustomerdetails/(:num)', 'TicketController::getCustomerDetails/$1');
        $routes->get('getpetugasdetails/(:num)', 'TicketController::getPetugasDetails/$1');

        $routes->post('api/tickets/create', 'Api\TicketController::create');
    });
     $routes->group('broadcast', function ($routes) {
        $routes->get('/', 'BroadcastController::index');
        $routes->post('send', 'BroadcastController::send');
    });
});
