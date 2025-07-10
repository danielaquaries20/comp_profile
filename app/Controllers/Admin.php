<?php

namespace App\Controllers;

class Admin extends BaseController
{

    // Deklarasi properti model yang akan digunakan
    protected $contactModel;
    protected $adminUserModel;
    protected $companySettingsModel;
    protected $serviceModel;
    protected $partnerModel;

    // Konstruktor: menginisialisasi semua model yang dibutuhkan
    public function __construct()
    {
        $this->contactModel = new \App\Models\ContactModel();
        $this->adminUserModel = new \App\Models\AdminUserModel();
        $this->companySettingsModel = new \App\Models\CompanySettingsModel();
        $this->serviceModel = new \App\Models\ServiceModel();
        $this->partnerModel = new \App\Models\PartnerModel();
    }


    public function genpass()
    {
        echo password_hash('admin123', PASSWORD_DEFAULT);
        // echo password_verify('ADMIN123456', '$2y$10$.ZB07oCmM6AOZ.lIaW46hOEt0S9V2RBKiiHyLsLWeLD6ZvHTZ9w9W');
    }

    public function coba()
    {
        $password = 'ADMIN123456';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        echo "Hash generated: " . $hash . "\n";

        $verify = password_verify($password, $hash);
        echo "Verify result: ";
        var_dump($verify);

        // Simulate saving to database
        $hash_db = $hash;

        // Simulate reading from database
        $verify_db = password_verify($password, $hash_db);
        echo "Verify after simulated DB storage: ";
        var_dump($verify_db);
    }


    // Dashboard admin
    public function index()
    {
        // Jika belum login, redirect ke login
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        // Data yang dikirim ke view dashboard
        $data = [
            'title' => 'Admin Dashboard - PT. Samsudi Indoniaga Sedaya',
            'contacts' => $this->contactModel->getContacts(20),
            'unread_count' => $this->contactModel->getUnreadCount(),
            'admin_user' => session()->get('admin_user')
        ];

        return view('admin/dashboard', $data);
    }

    // Halaman login admin
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        $data = [
            'title' => 'Login Admin - PT. Samsudi Indoniaga Sedaya'
        ];

        return view('admin/login', $data);
    }

    // Proses autentikasi login
    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Cek kredensial user
        $user = $this->adminUserModel->verifyCredentials($email, $password);

        if ($user) {
            // Set session jika berhasil login
            session()->set([
                'admin_logged_in' => true,
                'admin_user' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => $user['name'],
                    'role' => $user['role']
                ]
            ]);

            return redirect()->to('/admin')->with('success', 'Login berhasil!');
        }

        // Jika gagal login
        return redirect()->back()->withInput()->with('error', 'Email atau password salah!');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'Anda telah logout!');
    }

    // Tandai satu pesan sebagai "read"
    public function markAsRead($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $this->contactModel->updateStatus($id, 'read');
        return redirect()->back()->with('success', 'Pesan ditandai sebagai dibaca!');
    }

    // Hapus satu pesan
    public function deleteContact($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $this->contactModel->delete($id);
        return redirect()->back()->with('success', 'Pesan berhasil dihapus!');
    }

    // Tampilkan halaman pengaturan perusahaan
    public function settings()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Company Settings - Admin Panel',
            'settings' => $this->companySettingsModel->getAllSettings(),
            'admin_user' => session()->get('admin_user')
        ];

        return view('admin/settings', $data);
    }

    // Tampilkan halaman manajemen layanan
    public function services()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Services Management - Admin Panel',
            'services' => $this->serviceModel->findAll(),
            'admin_user' => session()->get('admin_user')
        ];

        return view('admin/services', $data);
    }

    // Tampilkan halaman manajemen mitra
    public function partners()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Partners Management - Admin Panel',
            'partners' => $this->partnerModel->getAllPartners(),
            'admin_user' => session()->get('admin_user')
        ];

        return view('admin/partners', $data);
    }

    // Inisialisasi data default (admin, settings, layanan)
    public function initializeData()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        try {
            // Create default admin user
            $this->adminUserModel->createDefaultAdmin();

            // Initialize company settings
            $this->companySettingsModel->initializeDefaults();

            // Initialize services
            $this->serviceModel->initializeDefaults();

            return redirect()->to('/admin')->with('success', 'Data berhasil diinisialisasi!');
        } catch (\Exception $e) {
            return redirect()->to('/admin')->with('error', 'Gagal menginisialisasi data: ' . $e->getMessage());
        }
    }

    // Tampilkan daftar pesan kontak
    public function contacts()
    {
        // Authentication check
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data = [
            'title' => 'Contact Messages - Admin Panel',
            'contacts' => $this->contactModel->getContacts(50), // Show more messages
            'unread_count' => $this->contactModel->getUnreadCount(),
            'admin_user' => session()->get('admin_user')
        ];

        return view('admin/contacts', $data);
    }

    // Tandai semua pesan sebagai "dibaca"
    public function markAllAsRead()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        try {
            $this->contactModel->markAllAsRead();
            return redirect()->to('/admin/contacts')->with('success', 'Semua pesan berhasil ditandai sebagai dibaca!');
        } catch (\Exception $e) {
            return redirect()->to('/admin/contacts')->with('error', 'Gagal menandai pesan: ' . $e->getMessage());
        }
    }

    // Hapus semua pesan yang sudah dibaca
    public function deleteAllRead()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        try {
            $deleted = $this->contactModel->deleteAllRead();
            return redirect()->to('/admin/contacts')->with('success', "Berhasil menghapus {$deleted} pesan yang sudah dibaca!");
        } catch (\Exception $e) {
            return redirect()->to('/admin/contacts')->with('error', 'Gagal menghapus pesan: ' . $e->getMessage());
        }
    }

    // Tampilkan form untuk ganti password admin
    public function changePassword()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
        $data = [
            'title' => 'Ganti Password Admin',
            'admin_user' => session()->get('admin_user')
        ];
        return view('admin/change_password', $data);
    }

    // Update password admin
    public function updatePassword()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
        $userId = session()->get('admin_user.id');
        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        log_message('debug', 'Update Password called with userId: ' . $userId);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'old_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ]);
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        // Verifikasi password lama
        $user = $this->adminUserModel->find($userId);
        if (!$user || !password_verify($oldPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama salah!');
        }
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        // Simpan password baru
        $this->adminUserModel->update($userId, [
            'password' => $hashedPassword
        ]);
        log_message('debug', 'Hashed new password: ' . $hashedPassword);
        return redirect()->to('/admin/change-password')->with('success', 'Password berhasil diganti!');
    }
}
