<?php

namespace App\Models;

use CodeIgniter\Model;

class PartnerModel extends Model
{

    // Nama tabel di database
    protected $table = 'partners';

    // Primary key
    protected $primaryKey = 'id';

    // Field Table yang boleh diinput/update
    protected $allowedFields = [
        'name',             // Nama partner/mitra
        'logo',             // Nama file logo gambar
        'website_url',      // URL website partner (opsional)
        'description',      // Deskripsi singkat
        'is_active',        // Status aktif/tidak
        'sort_order'        // Urutan tampilan
    ];

    // Aktifkan pencatatan waktu otomatis
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * ✅ Ambil semua partner yang aktif (is_active = 1)
     *    Diurutkan berdasarkan `sort_order` lalu `name`
     */
    public function getActivePartners()
    {
        return $this->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    /**
     * ✅ Ambil semua data partner (baik aktif maupun tidak)
     *    Digunakan untuk halaman admin (management partner)
     */
    public function getAllPartners()
    {
        return $this->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    /**
     * ✅ Ambil urutan (sort_order) selanjutnya secara otomatis
     *    Biasanya dipakai saat menambahkan partner baru
     */
    public function getNextSortOrder()
    {
        $result = $this->selectMax('sort_order')->first();
        return ($result['sort_order'] ?? 0) + 1;
    }

    /**
     * ✅ Fungsi untuk toggle status aktif/tidak
     *    Dipanggil ketika admin menekan tombol Aktif/Nonaktif partner
     */
    public function toggleStatus($id)
    {
        $partner = $this->find($id);
        if ($partner) {
            $newStatus = $partner['is_active'] ? 0 : 1;
            return $this->update($id, ['is_active' => $newStatus]);
        }
        return false;
    }
}