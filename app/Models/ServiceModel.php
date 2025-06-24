<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'description',
        'icon',
        'sort_order',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'title' => 'required|max_length[100]',
        'description' => 'required|max_length[500]',
        'icon' => 'required|max_length[50]',
        'sort_order' => 'integer'
    ];

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
     * Get active services ordered by sort_order
     */
    public function getActiveServices()
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    /**
     * Initialize default services
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

        foreach ($defaults as $service) {
            $existing = $this->where('title', $service['title'])->first();
            if (!$existing) {
                $this->insert($service);
            }
        }
    }
}