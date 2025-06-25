<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanySettingsModel extends Model {

    // Konfigurasi dasar model. Table: company_settings, tanpa soft delete, auto increment, return berupa array.
    protected $table = 'company_settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    //Hanya field yang diizinkan (allowedFields) yang bisa diisi atau di-update oleh query save(), insert(), atau update().
    protected $allowedFields = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description',
        'created_at',
        'updated_at'
    ];

    //Otomatis mengisi timestamp saat create/update (created_at dan updated_at).
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validasi:
    // setting_key wajib dan max 100 karakter
    // setting_value boleh kosong
    // setting_type hanya boleh salah satu dari yang ditentukan
    protected $validationRules = [
        'setting_key' => 'required|max_length[100]',
        'setting_value' => 'permit_empty',
        'setting_type' => 'required|in_list[text,textarea,email,phone,json,image]'
    ];

    //Pesan khusus yang akan ditampilkan jika validasi gagal.
    protected $validationMessages = [
        'setting_key' => [
            'required' => 'Setting key harus diisi.',
            'max_length' => 'Setting key maksimal 100 karakter.'
        ],
        'setting_type' => [
            'required' => 'Setting type harus diisi.',
            'in_list' => 'Setting type tidak valid.'
        ]
    ];

    // Mengambil nilai setting berdasarkan kunci setting_key.
    // Sangat berguna untuk site_config('company_name') di view.
    public function getSetting($key)
    {
        $setting = $this->where('setting_key', $key)->first();
        return $setting ? $setting['setting_value'] : null;
    }

    // Jika setting sudah ada → di-update.
    // Jika belum ada → insert baru.
    // Cocok dipanggil dari seeder atau halaman setting admin.
    public function updateSetting($key, $value, $type = 'text', $description = '')
    {
        $existing = $this->where('setting_key', $key)->first();

        $data = [
            'setting_key' => $key,
            'setting_value' => $value,
            'setting_type' => $type,
            'description' => $description
        ];

        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            return $this->insert($data);
        }
    }

    // Mengambil semua pengaturan dalam bentuk array terstruktur:
    // ['company_name' => ['value' => ..., 'type' => ..., 'desc' => ...]]
    // Memudahkan pemanggilan di admin panel.
    public function getAllSettings()
    {
        $settings = $this->findAll();
        $grouped = [];

        foreach ($settings as $setting) {
            $grouped[$setting['setting_key']] = [
                'value' => $setting['setting_value'],
                'type' => $setting['setting_type'],
                'description' => $setting['description']
            ];
        }

        return $grouped;
    }

    // Fungsi ini digunakan untuk mengisi setting awal secara otomatis.
    // Cukup panggil sekali (misalnya dari controller saat install/setup aplikasi pertama).
    public function initializeDefaults()
    {
        $defaults = [
            'company_name' => [
                'value' => 'PT. Samsudi Indoniaga Sedaya',
                'type' => 'text',
                'description' => 'Nama Perusahaan'
            ],
            'company_tagline' => [
                'value' => 'Solusi Niaga Terpercaya di Indonesia',
                'type' => 'text',
                'description' => 'Tagline Perusahaan'
            ],
            'company_description' => [
                'value' => 'Membangun kemitraan yang kuat dan memberikan layanan terbaik untuk kemajuan bisnis Anda dengan komitmen tinggi dan profesionalisme.',
                'type' => 'textarea',
                'description' => 'Deskripsi Perusahaan'
            ],
            'company_vision' => [
                'value' => 'Menjadi perusahaan terdepan dalam bidang perdagangan yang memberikan solusi inovatif dan berkelanjutan untuk kemajuan ekonomi Indonesia.',
                'type' => 'textarea',
                'description' => 'Visi Perusahaan'
            ],
            'company_mission' => [
                'value' => 'Memberikan layanan perdagangan yang berkualitas tinggi, membangun kemitraan strategis, dan berkontribusi positif terhadap pertumbuhan ekonomi nasional melalui praktik bisnis yang etis dan profesional.',
                'type' => 'textarea',
                'description' => 'Misi Perusahaan'
            ],
            'contact_address' => [
                'value' => 'Jl. Pemuda No. 123, Semarang<br>Jawa Tengah 50132, Indonesia',
                'type' => 'textarea',
                'description' => 'Alamat Perusahaan'
            ],
            'contact_phone' => [
                'value' => '+62 24 1234 5678',
                'type' => 'phone',
                'description' => 'Nomor Telepon'
            ],
            'contact_email' => [
                'value' => 'info@samsudiindoniaga.co.id',
                'type' => 'email',
                'description' => 'Email Perusahaan'
            ],
            'contact_hours' => [
                'value' => 'Senin - Jumat: 08:00 - 17:00 WIB<br>Sabtu: 08:00 - 12:00 WIB',
                'type' => 'textarea',
                'description' => 'Jam Operasional'
            ],
            'map_latitude' => [
                'value' => '-7.0278497',
                'type' => 'text',
                'description' => 'Latitude Lokasi'
            ],
            'map_longitude' => [
                'value' => '110.4393949',
                'type' => 'text',
                'description' => 'Longitude Lokasi'
            ],
            'mapbox_token' => [
                'value' => 'pk.eyJ1IjoicGFsb24wMDUiLCJhIjoiY21jMjJ4MDJvMDR0bzJqc2ZtMmxrOW56OSJ9.YFif8g-Il5g5qdynTCXLbA',
                'type' => 'text',
                'description' => 'Mapbox Access Token'
            ]
        ];

        foreach ($defaults as $key => $setting) {
            $existing = $this->where('setting_key', $key)->first();
            if (!$existing) {
                $this->updateSetting($key, $setting['value'], $setting['type'], $setting['description']);
            }
        }
    }
}