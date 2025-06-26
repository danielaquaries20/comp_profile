<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class CompanyApi extends ResourceController
{
    protected $companySettingsModel;
    protected $serviceModel;
    protected $format = 'json';
    public function __construct()
    {
        $this->companySettingsModel = new \App\Models\CompanySettingsModel();
        $this->serviceModel = new \App\Models\ServiceModel();
    }

    protected function checkAuth()
    {
        // Check if user is logged in for protected routes
        if (!$this->isValidApiRequest()) {
            return $this->failUnauthorized('Access denied');
        }
        return true;
    }

    private function isValidApiRequest()
    {
        // Check session for admin login
        if (session()->get('admin_logged_in')) {
            return true;
        }

        // Check for API key in header (optional for future use)
        $apiKey = $this->request->getHeaderLine('X-API-Key');
        if ($apiKey && $apiKey === env('API_KEY')) {
            return true;
        }

        return false;
    }
    /**
     * Get all company settings
     */
    public function getSettings()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck !== true) return $authCheck;

        try {
            $settings = $this->companySettingsModel->getAllSettings();

            return $this->respond([
                'status' => 'success',
                'data' => $settings
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Failed to get settings: ' . $e->getMessage());
        }
    }
    /**
     * Update company setting
     */
    public function updateSetting()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck !== true) return $authCheck;

        try {
            $json = $this->request->getJSON(true);

            if (!isset($json['key']) || !isset($json['value'])) {
                return $this->failValidationErrors('Key and value are required');
            }

            $key = $json['key'];
            $value = $json['value'];
            $type = $json['type'] ?? 'text';
            $description = $json['description'] ?? '';

            $result = $this->companySettingsModel->updateSetting($key, $value, $type, $description);

            if ($result) {
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Setting updated successfully'
                ]);
            } else {
                return $this->failServerError('Failed to update setting');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Failed to update setting: ' . $e->getMessage());
        }
    }
    /**
     * Get all services
     */
    public function getServices()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck !== true) return $authCheck;

        try {
            $services = $this->serviceModel->findAll();

            return $this->respond([
                'status' => 'success',
                'data' => $services
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Failed to get services: ' . $e->getMessage());
        }
    }
    /**
     * Create new service
     */    public function createService()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck !== true) return $authCheck;

        try {
            $json = $this->request->getJSON(true);

            log_message('debug', 'CreateService: Received JSON data: ' . json_encode($json));

            $validation = \Config\Services::validation();
            $validation->setRules([
                'title' => 'required|max_length[100]',
                'description' => 'required|max_length[500]',
                'icon' => 'required|max_length[50]'
            ]);

            if (!$validation->run($json)) {
                log_message('debug', 'CreateService: Validation failed: ' . json_encode($validation->getErrors()));
                return $this->failValidationErrors($validation->getErrors());
            }

            $data = [
                'title' => $json['title'],
                'description' => $json['description'],
                'icon' => $json['icon'],
                'sort_order' => $json['sort_order'] ?? 0,
                'is_active' => $json['is_active'] ?? 1
            ];

            log_message('debug', 'CreateService: Data to insert: ' . json_encode($data));

            $result = $this->serviceModel->insert($data);

            if ($result) {
                log_message('debug', 'CreateService: Service created successfully with ID: ' . $result);
                return $this->respondCreated([
                    'status' => 'success',
                    'message' => 'Service created successfully',
                    'id' => $result
                ]);
            } else {
                log_message('error', 'CreateService: Failed to create service');
                return $this->failServerError('Failed to create service');
            }
        } catch (\Exception $e) {
            log_message('error', 'CreateService: Exception: ' . $e->getMessage());
            return $this->failServerError('Failed to create service: ' . $e->getMessage());
        }
    }
    /**
     * Update service
     */    public function updateService($id)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck !== true) return $authCheck;

        try {
            $service = $this->serviceModel->find($id);
            if (!$service) {
                return $this->failNotFound('Service not found');
            }

            $json = $this->request->getJSON(true);

            $validation = \Config\Services::validation();
            $validation->setRules([
                'title' => 'required|max_length[100]',
                'description' => 'required|max_length[500]',
                'icon' => 'required|max_length[50]'
            ]);

            if (!$validation->run($json)) {
                return $this->failValidationErrors($validation->getErrors());
            }

            $data = [
                'title' => $json['title'],
                'description' => $json['description'],
                'icon' => $json['icon'],
                'sort_order' => $json['sort_order'] ?? $service['sort_order'],
                'is_active' => $json['is_active'] ?? $service['is_active']
            ];

            $result = $this->serviceModel->update($id, $data);

            if ($result) {
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Service updated successfully'
                ]);
            } else {
                return $this->failServerError('Failed to update service');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Failed to update service: ' . $e->getMessage());
        }
    }

    /**
     * Delete service
     */
    public function deleteService($id)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck !== true) return $authCheck;

        try {
            $service = $this->serviceModel->find($id);
            if (!$service) {
                return $this->failNotFound('Service not found');
            }

            $result = $this->serviceModel->delete($id);

            if ($result) {
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Service deleted successfully'
                ]);
            } else {
                return $this->failServerError('Failed to delete service');
            }
        } catch (\Exception $e) {
            return $this->failServerError('Failed to delete service: ' . $e->getMessage());
        }
    }
    /**
     * Bulk update settings
     */
    public function bulkUpdateSettings()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck !== true) return $authCheck;

        try {
            $json = $this->request->getJSON(true);
            log_message('info', 'Bulk update settings request: ' . json_encode($json));

            if (!isset($json['settings']) || !is_array($json['settings'])) {
                return $this->failValidationErrors('Settings array is required');
            }

            $updated = 0;
            $errors = [];

            foreach ($json['settings'] as $setting) {
                if (!isset($setting['key'])) {
                    $errors[] = 'Missing key for setting';
                    continue;
                }

                // Allow empty values for deletion
                $value = isset($setting['value']) ? $setting['value'] : '';

                log_message('info', "Updating setting: {$setting['key']} = '{$value}'");

                $result = $this->companySettingsModel->updateSetting(
                    $setting['key'],
                    $value,
                    $setting['type'] ?? 'text',
                    $setting['description'] ?? ''
                );

                if ($result) {
                    $updated++;
                    log_message('info', "Successfully updated setting: {$setting['key']}");
                } else {
                    $error = "Failed to update setting: {$setting['key']}";
                    $errors[] = $error;
                    log_message('error', $error);
                }
            }

            $response = [
                'status' => 'success',
                'message' => "Updated {$updated} settings",
                'updated' => $updated,
                'errors' => $errors
            ];

            log_message('info', 'Bulk update response: ' . json_encode($response));

            return $this->respond($response);
        } catch (\Exception $e) {
            log_message('error', 'Bulk update settings error: ' . $e->getMessage());
            return $this->failServerError('Failed to bulk update settings: ' . $e->getMessage());
        }
    }
}
