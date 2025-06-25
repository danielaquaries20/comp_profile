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
