<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PartnerApi extends BaseController
{
    protected $partnerModel;

    public function __construct()
    {
        $this->partnerModel = new \App\Models\PartnerModel();
    }
    /**
     * Get all partners
     */
    public function index()
    {
        // Check auth for admin only
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        try {
            $partners = $this->partnerModel->getAllPartners();
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $partners
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Failed to get partners: ' . $e->getMessage()
            ]);
        }
    }
    /**
     * Get partner by ID
     */
    public function show($id)
    {
        // Check auth for admin only
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        try {
            $partner = $this->partnerModel->find($id);
            if (!$partner) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => 'error',
                    'message' => 'Partner not found'
                ]);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $partner
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Failed to get partner: ' . $e->getMessage()
            ]);
        }
    }
    /**
     * Create new partner
     */
    public function create()
    {
        // Check auth for admin only
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        try {
            $data = $this->request->getJSON(true);

            // Validation
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|max_length[100]',
                'website_url' => 'permit_empty|valid_url|max_length[255]',
                'description' => 'permit_empty|max_length[1000]',
                'is_active' => 'permit_empty|in_list[0,1]',
                'sort_order' => 'permit_empty|integer'
            ]);

            if (!$validation->run($data)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validation->getErrors()
                ]);
            }

            // Set default sort order if not provided
            if (!isset($data['sort_order'])) {
                $data['sort_order'] = $this->partnerModel->getNextSortOrder();
            }

            $partnerId = $this->partnerModel->insert($data);
            $partner = $this->partnerModel->find($partnerId);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Partner created successfully',
                'data' => $partner
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Failed to create partner: ' . $e->getMessage()
            ]);
        }
    }
    /**
     * Update partner
     */
    public function update($id)
    {
        // Check auth for admin only
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        try {
            $data = $this->request->getJSON(true);

            // Check if partner exists
            $partner = $this->partnerModel->find($id);
            if (!$partner) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => 'error',
                    'message' => 'Partner not found'
                ]);
            }

            // Validation
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|max_length[100]',
                'website_url' => 'permit_empty|valid_url|max_length[255]',
                'description' => 'permit_empty|max_length[1000]',
                'is_active' => 'permit_empty|in_list[0,1]',
                'sort_order' => 'permit_empty|integer'
            ]);

            if (!$validation->run($data)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validation->getErrors()
                ]);
            }

            $this->partnerModel->update($id, $data);
            $updatedPartner = $this->partnerModel->find($id);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Partner updated successfully',
                'data' => $updatedPartner
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Failed to update partner: ' . $e->getMessage()
            ]);
        }
    }
    /**
     * Delete partner
     */
    public function delete($id)
    {
        // Check auth for admin only
        if (!session()->get('admin_logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Access denied'
            ]);
        }

        try {
            $partner = $this->partnerModel->find($id);
            if (!$partner) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => 'error',
                    'message' => 'Partner not found'
                ]);
            }

            // Delete logo file if exists
            if (!empty($partner['logo'])) {
                $logoPath = FCPATH . 'assets/images/uploads/' . $partner['logo'];
                if (file_exists($logoPath)) {
                    unlink($logoPath);
                }
            }

            $this->partnerModel->delete($id);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Partner deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete partner: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Toggle partner status
     */
    public function toggleStatus($id)
    {
        try {
            $partner = $this->partnerModel->find($id);
            if (!$partner) {
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => 'error',
                    'message' => 'Partner not found'
                ]);
            }

            $success = $this->partnerModel->toggleStatus($id);
            if ($success) {
                $updatedPartner = $this->partnerModel->find($id);
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Partner status updated successfully',
                    'data' => $updatedPartner
                ]);
            } else {
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to update partner status'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Failed to toggle partner status: ' . $e->getMessage()
            ]);
        }
    }
}
