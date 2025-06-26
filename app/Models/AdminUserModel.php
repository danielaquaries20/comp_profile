<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminUserModel extends Model
{
    protected $table = 'admin_users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
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

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[admin_users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'name' => 'required|min_length[3]|max_length[100]',
        'role' => 'required|in_list[admin,super_admin]'
    ];

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

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Verify user credentials
     */
    public function verifyCredentials($email, $password)
    {
        $user = $this->where('email', $email)
            ->where('is_active', 1)
            ->first();

        if ($user && password_verify($password, $user['password'])) {
            // Update last login
            $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $user;
        }

        return false;
    }

    /**
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Create default admin user
     */
    public function createDefaultAdmin()
    {
        $existing = $this->where('email', 'admin@samsudiindoniaga.co.id')->first();

        if (!$existing) {
            $this->insert([
                'email' => 'admin@samsudiindoniaga.co.id',
                'password' => 'admin123',
                'name' => 'Administrator',
                'role' => 'super_admin',
                'is_active' => 1
            ]);
        }
    }
}
