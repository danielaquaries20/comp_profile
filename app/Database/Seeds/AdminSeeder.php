<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Default admin user
        $adminData = [
            'email' => 'admin@company.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'name' => 'Administrator',
            'role' => 'super_admin',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Check if admin already exists
        $existingAdmin = $this->db->table('admin_users')
            ->where('email', $adminData['email'])
            ->get()
            ->getRow();

        if (!$existingAdmin) {
            $this->db->table('admin_users')->insert($adminData);
            echo "Admin user created successfully!\n";
            echo "Email: admin@company.com\n";
            echo "Password: admin123\n";
        } else {
            echo "Admin user already exists!\n";
        }

         // Default company settings
        $defaultSettings = [
            [
                'setting_key' => 'company_name',
                'setting_value' => 'PT. Samsudi Indoniaga Sedaya',
                'setting_type' => 'text',
                'description' => 'Nama perusahaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'company_tagline',
                'setting_value' => 'Solusi Niaga Terpercaya di Indonesia',
                'setting_type' => 'text',
                'description' => 'Tagline perusahaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'company_description',
                'setting_value' => 'Membangun kemitraan yang kuat dan memberikan layanan terbaik untuk kemajuan bisnis Anda dengan komitmen tinggi dan profesionalisme.',
                'setting_type' => 'textarea',
                'description' => 'Deskripsi perusahaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'company_vision',
                'setting_value' => 'Menjadi perusahaan terdepan dalam bidang perdagangan yang memberikan solusi inovatif dan berkelanjutan untuk kemajuan ekonomi Indonesia.',
                'setting_type' => 'textarea',
                'description' => 'Visi perusahaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'company_mission',
                'setting_value' => 'Memberikan layanan perdagangan yang berkualitas tinggi, membangun kemitraan strategis, dan berkontribusi positif terhadap pertumbuhan ekonomi nasional melalui praktik bisnis yang etis dan profesional.',
                'setting_type' => 'textarea',
                'description' => 'Misi perusahaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'contact_address',
                'setting_value' => 'Jl. Sudirman No. 123, Jakarta Selatan 12190, Indonesia',
                'setting_type' => 'textarea',
                'description' => 'Alamat perusahaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'contact_phone',
                'setting_value' => '+62 21 1234 5678',
                'setting_type' => 'phone',
                'description' => 'Nomor telepon perusahaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'contact_email',
                'setting_value' => 'info@samsudi.com',
                'setting_type' => 'email',
                'description' => 'Email perusahaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'contact_whatsapp',
                'setting_value' => '+62 812 3456 7890',
                'setting_type' => 'phone',
                'description' => 'Nomor WhatsApp perusahaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'hero_title',
                'setting_value' => 'Solusi Niaga Terpercaya untuk Kemajuan Bisnis Anda',
                'setting_type' => 'text',
                'description' => 'Judul hero section',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'hero_subtitle',
                'setting_value' => 'Membangun kemitraan strategis dan memberikan layanan berkualitas tinggi dalam bidang perdagangan untuk mendukung pertumbuhan ekonomi nasional.',
                'setting_type' => 'textarea',
                'description' => 'Subtitle hero section',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'mapbox_token',
                'setting_value' => 'your_mapbox_access_token_here',
                'setting_type' => 'text',
                'description' => 'Mapbox access token untuk menampilkan peta',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'hero_background_image',
                'setting_value' => '',
                'setting_type' => 'image',
                'description' => 'Background image untuk hero section',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'company_logo',
                'setting_value' => '',
                'setting_type' => 'image',
                'description' => 'Logo perusahaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'about_image',
                'setting_value' => '',
                'setting_type' => 'image',
                'description' => 'Gambar untuk section about',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

         // Insert default settings
        foreach ($defaultSettings as $setting) {
            $existing = $this->db->table('company_settings')
                ->where('setting_key', $setting['setting_key'])
                ->get()
                ->getRow();

            if (!$existing) {
                $this->db->table('company_settings')->insert($setting);
            }
        }

         echo "Default company settings created successfully!\n";        // Default services
        $defaultServices = [
            [
                'title' => 'Konsultasi Bisnis',
                'description' => 'Layanan konsultasi strategis untuk mengembangkan bisnis Anda dengan pendekatan yang tepat dan teruji.',
                'icon' => 'fas fa-chart-line',
                'is_active' => 1,
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Distribusi Produk',
                'description' => 'Jaringan distribusi yang luas dan efisien untuk menjangkau pasar di seluruh Indonesia.',
                'icon' => 'fas fa-shipping-fast',
                'is_active' => 1,
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Kemitraan Strategis',
                'description' => 'Membangun hubungan kemitraan yang saling menguntungkan dengan berbagai pihak.',
                'icon' => 'fas fa-handshake',
                'is_active' => 1,
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Solusi Digital',
                'description' => 'Implementasi teknologi digital untuk meningkatkan efisiensi dan daya saing bisnis.',
                'icon' => 'fas fa-laptop-code',
                'is_active' => 1,
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert default services
        foreach ($defaultServices as $service) {
            $existing = $this->db->table('services')
                ->where('title', $service['title'])
                ->get()
                ->getRow();

            if (!$existing) {
                $this->db->table('services')->insert($service);
            }
        }

         echo "Default services created successfully!\n";

        // Default partners
        $defaultPartners = [
            [
                'name' => 'PT. Teknologi Masa Depan',
                'logo' => '',
                'website_url' => 'https://teknologi-masa-depan.com',
                'description' => 'Partner teknologi terdepan dalam solusi digital',
                'is_active' => 1,
                'sort_order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'CV. Mitra Sukses Bersama',
                'logo' => '',
                'website_url' => 'https://mitrasuksesbersama.co.id',
                'description' => 'Kemitraan strategis dalam bidang perdagangan',
                'is_active' => 1,
                'sort_order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'PT. Global Niaga Indonesia',
                'logo' => '',
                'website_url' => 'https://globalniaga.com',
                'description' => 'Partner distribusi dengan jangkauan nasional',
                'is_active' => 1,
                'sort_order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'PT. Inovasi Digital Nusantara',
                'logo' => '',
                'website_url' => 'https://inovasidigital.id',
                'description' => 'Solusi inovasi digital untuk transformasi bisnis',
                'is_active' => 1,
                'sort_order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'CV. Sinergi Bisnis Mandiri',
                'logo' => '',
                'website_url' => 'https://sinergibisnis.net',
                'description' => 'Kemitraan bisnis yang saling menguntungkan',
                'is_active' => 1,
                'sort_order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'PT. Konsultan Profesional',
                'logo' => '',
                'website_url' => 'https://konsultanpro.com',
                'description' => 'Layanan konsultasi bisnis dan manajemen',
                'is_active' => 1,
                'sort_order' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

         // Insert default partners
        foreach ($defaultPartners as $partner) {
            $existing = $this->db->table('partners')
                ->where('name', $partner['name'])
                ->get()
                ->getRow();

            if (!$existing) {
                $this->db->table('partners')->insert($partner);
            }
        }

        echo "Default partners created successfully!\n";
    }
}
