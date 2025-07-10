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


$routes->get('/genpass', 'Admin::genpass');
$routes->get('/coba', 'Admin::coba');


// Admin Routes
$routes->group('admin', function ($routes) {
    // Menampilkan dashboard admin (halaman utama setelah login).
    $routes->get('/', 'Admin::index');

    // Menampilkan halaman login admin.
    $routes->get('login', 'Admin::login');

    // Memproses login admin dari form login (validasi & set session).
    $routes->post('authenticate', 'Admin::authenticate');

    // 	Menghapus session login dan redirect ke halaman login.
    $routes->get('logout', 'Admin::logout');

    // 	Menampilkan daftar pesan/kontak yang masuk.
    $routes->get('contacts', 'Admin::contacts');

    // 	Menandai satu pesan dengan ID tertentu ($1) sebagai dibaca.
    $routes->get('mark-read/(:num)', 'Admin::markAsRead/$1');

    // Menandai semua pesan sebagai dibaca.
    $routes->get('mark-all-read', 'Admin::markAllAsRead');

    // Menghapus satu pesan dengan ID tertentu ($1).
    $routes->get('delete/(:num)', 'Admin::deleteContact/$1');

    // 	Menghapus semua pesan yang sudah dibaca.
    $routes->get('delete-all-read', 'Admin::deleteAllRead');

    // Menampilkan halaman pengaturan perusahaan (company settings).
    $routes->get('settings', 'Admin::settings');

    // Menampilkan halaman manajemen layanan/jasa yang disediakan.
    $routes->get('services', 'Admin::services');

    // 	Menampilkan halaman manajemen partner/rekanan perusahaan.
    $routes->get('partners', 'Admin::partners');

    // Menjalankan inisialisasi data default (admin, settings, services, dll).
    $routes->get('initialize', 'Admin::initializeData');

    // 	Menampilkan halaman ubah password untuk admin.
    $routes->get('change-password', 'Admin::changePassword');

    // Memproses pengubahan password admin yang sedang login.
    $routes->post('update-password', 'Admin::updatePassword');
});


// Image Upload Routes
$routes->group('upload', function ($routes) {
    // Mengunggah gambar ke server. Digunakan saat admin meng-upload gambar lewat form.
    $routes->post('image', 'ImageUpload::upload');
    // Menghapus gambar dari server. Digunakan saat admin ingin menghapus gambar yang sudah di-upload.
    $routes->post('delete-image', 'ImageUpload::delete');
});


// API Routes
$routes->group('api', function ($routes) {
    $routes->group('company', function ($routes) {
        // Mengambil semua pengaturan perusahaan
        $routes->get('settings', 'Api\CompanyApi::getSettings');

        // 	Memperbarui satu pengaturan perusahaan (key-value)
        $routes->post('settings', 'Api\CompanyApi::updateSetting');

        // 	Memperbarui banyak pengaturan sekaligus
        $routes->post('settings/bulk', 'Api\CompanyApi::bulkUpdateSettings');

        // 	Menampilkan semua layanan (services) perusahaan
        $routes->get('services', 'Api\CompanyApi::getServices');

        // 	Menambahkan layanan baru
        $routes->post('services', 'Api\CompanyApi::createService');

        // 	Memperbarui data layanan berdasarkan ID
        $routes->put('services/(:num)', 'Api\CompanyApi::updateService/$1');

        // Menghapus layanan berdasarkan ID
        $routes->delete('services/(:num)', 'Api\CompanyApi::deleteService/$1');
    });

    $routes->group('partners', function ($routes) {
        // Mengambil semua partner
        $routes->get('/', 'Api\PartnerApi::index');
        
        // 	Mengambil detail partner berdasarkan ID
        $routes->get('(:num)', 'Api\PartnerApi::show/$1');

        // 	Menambahkan partner baru
        $routes->post('/', 'Api\PartnerApi::create');

        // Memperbarui data partner
        $routes->put('(:num)', 'Api\PartnerApi::update/$1');

        // Menghapus partner berdasarkan ID
        $routes->delete('(:num)', 'Api\PartnerApi::delete/$1');

        // Mengaktifkan/nonaktifkan partner (flip boolean is_active)
        $routes->post('(:num)/toggle-status', 'Api\PartnerApi::toggleStatus/$1');
    });
});
