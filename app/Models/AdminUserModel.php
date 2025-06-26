<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUserModel extends Model
{

    // Nama tabel yang digunakan oleh model
    protected $table = 'admin_users';

    // Primary key dari tabel
    protected $primaryKey = 'id';

    // Auto increment diaktifkan untuk primary key
    protected $useAutoIncrement = true;

    // Format data yang dikembalikan oleh model
    protected $returnType = 'array';

    // Soft delete tidak digunakan (baris tidak disembunyikan saat "hapus")
    protected $useSoftDeletes = false;

    // Mencegah field yang tidak diizinkan untuk disisipkan/diubah
    protected $protectFields = true;

    // Field yang boleh diisi saat insert/update
    protected $allowedFields = [
        'email',
        'password',
        'name',
        'role',
        'is_active',
        'last_login',
        'created_at',
        'updated_at'
    ];

    // Timestamp otomatis aktif
    protected $useTimestamps = true;

    // Format datetime yang digunakan
    protected $dateFormat = 'datetime';

    // Nama kolom untuk mencatat kapan data dibuat dan diperbarui
    protected $createdField = 'created_at';

    // Aturan validasi input data
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[admin_users.email,id,{id}]', // email wajib, valid, dan unik
        'password' => 'required|min_length[6]',                                 // password wajib dan minimal 6 karakter
        'name' => 'required|min_length[3]|max_length[100]',                     // nama wajib dan panjang 3-100
        'role' => 'required|in_list[admin,super_admin]'                         // role hanya boleh admin atau super_admin
    ];

    // Pesan error kustom untuk validasi
    protected $validationMessages = [
        'email' => [
            'required' => 'Email harus diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique' => 'Email sudah terdaftar.'
        ],
        'password' => [
            'required' => 'Password harus diisi.',
            'min_length' => 'Password minimal 6 karakter.'
        ],
        'name' => [
            'required' => 'Nama harus diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
            'max_length' => 'Nama maksimal 100 karakter.'
        ],
        'role' => [
            'required' => 'Role harus diisi.',
            'in_list' => 'Role tidak valid.'
        ]
    ];

    // Callback sebelum data diinsert/update: memanggil fungsi hashPassword
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];


    /**
     * Callback untuk meng-hash password sebelum disimpan ke database
     * @param array $data
     * @return array
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Verifikasi login user berdasarkan email dan password
     * @param string $email
     * @param string $password
     * @return array|false
     */
    public function verifyCredentials($email, $password)
    {
        // Cari user berdasarkan email dan status aktif
        $user = $this->where('email', $email)
            ->where('is_active', 1)
            ->first();

        // Jika user ditemukan dan password cocok
        if ($user && password_verify($password, $user['password'])) {
            // Perbarui waktu login terakhir
            $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $user;
        }

        // Login gagal
        return false;
    }

    /**
     * Mengambil data user berdasarkan email
     * @param string $email
     * @return array|null
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Membuat user default super admin jika belum ada
     */
    public function createDefaultAdmin()
    {
        $existing = $this->where('email', 'admin@samsudiindoniaga.co.id')->first();

        if (!$existing) {
            $this->insert([
                'email' => 'admin@samsudiindoniaga.co.id',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'name' => 'Administrator',
                'role' => 'super_admin',
                'is_active' => 1
            ]);
        }
    }
}
