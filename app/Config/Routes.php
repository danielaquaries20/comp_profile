<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

// Halaman utama (beranda)
$routes->get('/', 'CompanyProfile::index');

// Halaman tentang
$routes->get('/tentang', 'CompanyProfile::about');

// Halaman layanan
$routes->get('/layanan', 'CompanyProfile::services');

// Halaman kontak
$routes->get('/kontak', 'CompanyProfile::contact');

// Proses submit form kontak
$routes->post('/contact/submit', 'CompanyProfile::submitContact');



// Admin Routes
$routes->group('admin', function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('login', 'Admin::login');
    $routes->post('authenticate', 'Admin::authenticate');
    $routes->get('logout', 'Admin::logout');
    $routes->get('contacts', 'Admin::contacts');
    $routes->get('mark-read/(:num)', 'Admin::markAsRead/$1');
    $routes->get('mark-all-read', 'Admin::markAllAsRead');
    $routes->get('delete/(:num)', 'Admin::deleteContact/$1');
    $routes->get('delete-all-read', 'Admin::deleteAllRead');
    $routes->get('settings', 'Admin::settings');
    $routes->get('services', 'Admin::services');
    $routes->get('partners', 'Admin::partners');
    $routes->get('initialize', 'Admin::initializeData');
    $routes->get('change-password', 'Admin::changePassword');
    $routes->post('update-password', 'Admin::updatePassword');
});
