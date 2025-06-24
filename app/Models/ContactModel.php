<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama',
        'email',
        'pesan',
        'status',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'pesan' => 'required|min_length[10]|max_length[1000]'
    ];

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
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
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
     * Get all contacts with pagination
     */
    public function getContacts($limit = 10, $offset = 0)
    {
        return $this->orderBy('created_at', 'DESC')
            ->findAll($limit, $offset);
    }

    /**
     * Get contact by ID
     */
    public function getContact($id)
    {
        return $this->find($id);
    }

    /**
     * Save contact message
     */
    public function saveContact($data)
    {
        return $this->save($data);
    }

    /**
     * Update contact status
     */
    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    /**
     * Get unread contacts count
     */
    public function getUnreadCount()
    {
        return $this->where('status', 'unread')->countAllResults();
    }

    /**
     * Tandai semua pesan sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        return $this->where('status', 'unread')
            ->set(['status' => 'read'])
            ->update();
    }

    public function deleteAllRead()
    {
        return $this->where('status', 'read')
            ->delete();
    }

}