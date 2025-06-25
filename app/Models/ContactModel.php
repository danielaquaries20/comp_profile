<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{

    // Nama tabel di database
    protected $table = 'contacts';

    // Primary key
    protected $primaryKey = 'id';

    // Auto increment
    protected $useAutoIncrement = true;

    // Format data kembalian (array, bisa juga object)
    protected $returnType = 'array';

    // Tidak menggunakan soft delete (bisa diaktifkan jika perlu)
    protected $useSoftDeletes = false;

    // Lindungi field agar hanya allowedFields yang bisa diisi
    protected $protectFields = true;

    // Field Contact yang boleh disimpan/update ke DB
    protected $allowedFields = [
        'nama',             // Nama pengirim
        'email',            // Email pengirim
        'pesan',            // Isi pesan
        'status',           // Status (unread/read/replied)
        'created_at',       
        'updated_at',
        'investasi_idr'     // Nilai rencana investasi
    ];

    // Konfigurasi timestamp otomatis
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Aturan validasi input pengguna
    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'pesan' => 'required|min_length[10]|max_length[1000]',
        'investasi_idr' => 'required|numeric|max_length[9]'
    ];

    // Pesan validasi yang ditampilkan jika input tidak sesuai
    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama harus diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
            'max_length' => 'Nama maksimal 100 karakter.'
        ],
        'email' => [
            'required' => 'Email harus diisi.',
            'valid_email' => 'Format email tidak valid.',
            'max_length' => 'Email maksimal 100 karakter.'
        ],
        'pesan' => [
            'required' => 'Pesan harus diisi.',
            'min_length' => 'Pesan minimal 10 karakter.',
            'max_length' => 'Pesan maksimal 1000 karakter.'
        ],
        'investasi_idr' => [
            'required' => 'Investasi uang harus diisi.',
            'numeric' => 'Investasi uang harus berupa angka.',
            'max_length' => 'Investasi paling banyak hanya Rp 999.999.999 tidak boleh lebih'
        ]
    ];

    // Atur validasi agar tidak dilewati
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callback (kosong untuk sekarang, bisa ditambahkan custom logic)
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * ✅ Ambil semua pesan kontak dengan limitasi (untuk pagination admin)
     */
    public function getContacts($limit = 10, $offset = 0)
    {
        return $this->orderBy('created_at', 'DESC')
            ->findAll($limit, $offset);
    }

    /**
     * ✅ Ambil pesan berdasarkan ID tertentu (misalnya untuk detail pesan)
     */
    public function getContact($id)
    {
        return $this->find($id);
    }

    /**
     * ✅ Simpan pesan baru ke database
     */
    public function saveContact($data)
    {
        return $this->save($data);
    }

    /**
     * ✅ Update status pesan (misal: tandai sudah dibaca)
     */
    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    /**
     * ✅ Hitung jumlah pesan yang belum dibaca
     *    Digunakan untuk notifikasi admin
     */
    public function getUnreadCount()
    {
        return $this->where('status', 'unread')->countAllResults();
    }

    /**
     * ✅ Tandai semua pesan sebagai sudah dibaca
     *    Biasanya saat admin klik "Tandai semua dibaca"
     */
    public function markAllAsRead()
    {
        return $this->where('status', 'unread')
            ->set(['status' => 'read'])
            ->update();
    }

    /**
     * ✅ Hapus semua pesan yang status-nya sudah dibaca
     *    Untuk fitur "Bulk delete" pada kontak admin
     */
    public function deleteAllRead()
    {
        return $this->where('status', 'read')
            ->delete();
    }

}