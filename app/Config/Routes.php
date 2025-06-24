<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'CompanyProfile::index');
$routes->get('/tentang', 'CompanyProfile::about');
$routes->get('/layanan', 'CompanyProfile::services');
$routes->get('/kontak', 'CompanyProfile::contact');
$routes->post('/contact/submit', 'CompanyProfile::submitContact');
