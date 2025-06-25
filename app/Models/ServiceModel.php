<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    // Nama tabel di database
    protected $table = 'services';

    // Primary key tabel
    protected $primaryKey = 'id';

    // Auto increment ID
    protected $useAutoIncrement = true;

    // Format return: array
    protected $returnType = 'array';

    // Tidak pakai soft delete
    protected $useSoftDeletes = false;

    // Proteksi field agar hanya bisa input/update field di bawah
    protected $protectFields = true;

    // Field yang diizinkan untuk insert/update
    protected $allowedFields = [
        'title',                // Judul layanan
        'description',          // Deskripsi layanan
        'icon',                 // Icon layanan (font-awesome atau emoji)
        'sort_order',           // Urutan tampilan
        'is_active',            // Status aktif atau tidak
        'created_at',
        'updated_at'
    ];

    // Konfigurasi timestamp otomatis
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Aturan validasi untuk form input layanan
    protected $validationRules = [
        'title' => 'required|max_length[100]',
        'description' => 'required|max_length[500]',
        'icon' => 'required|max_length[50]',
        'sort_order' => 'integer'
    ];


    // Pesan error kustom untuk validasi
    protected $validationMessages = [
        'title' => [
            'required' => 'Judul service harus diisi.',
            'max_length' => 'Judul service maksimal 100 karakter.'
        ],
        'description' => [
            'required' => 'Deskripsi service harus diisi.',
            'max_length' => 'Deskripsi service maksimal 500 karakter.'
        ],
        'icon' => [
            'required' => 'Icon service harus diisi.',
            'max_length' => 'Icon service maksimal 50 karakter.'
        ]
    ];

    /**
     * ✅ Ambil semua layanan yang aktif (is_active = 1)
     *    dan urutkan berdasarkan sort_order
     */
    public function getActiveServices()
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

   /**
     * ✅ Inisialisasi data default ke dalam tabel services
     *    jika belum ada datanya (biasanya dipakai saat seeding)
     */
    public function initializeDefaults()
    {
        $defaults = [
            [
                'title' => 'Konsultasi Bisnis',
                'description' => 'Memberikan konsultasi strategis untuk mengoptimalkan kinerja bisnis dan mencapai target yang diinginkan.',
                'icon' => '📊',
                'sort_order' => 1,
                'is_active' => 1
            ],
            [
                'title' => 'Kemitraan Strategis',
                'description' => 'Membangun jaringan kemitraan yang kuat untuk memperluas jangkauan bisnis dan peluang pasar.',
                'icon' => '🤝',
                'sort_order' => 2,
                'is_active' => 1
            ],
            [
                'title' => 'Distribusi & Logistik',
                'description' => 'Layanan distribusi dan logistik yang efisien untuk memastikan produk sampai tepat waktu dan kondisi prima.',
                'icon' => '🚚',
                'sort_order' => 3,
                'is_active' => 1
            ],
            [
                'title' => 'Analisis Pasar',
                'description' => 'Analisis mendalam tentang tren pasar dan peluang bisnis untuk pengambilan keputusan yang tepat.',
                'icon' => '📈',
                'sort_order' => 4,
                'is_active' => 1
            ]
        ];

        // Cek apakah data default sudah ada di database
        foreach ($defaults as $service) {
            $existing = $this->where('title', $service['title'])->first();
            if (!$existing) {
                $this->insert($service);
            }
        }
    }
}