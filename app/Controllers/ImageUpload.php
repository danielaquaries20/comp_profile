<?php

namespace App\Controllers;

use CodeIgniter\Files\File;

class ImageUpload extends BaseController
{
    public function upload()
    {
        // Check if user is admin
        if (!session()->get('admin_logged_in')) {
            return $this->failUnauthorized('Access denied');
        }

        $validationRule = [
            'image' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[image]',
                    'is_image[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                    'max_size[image,2048]', // 2MB max
                ],
            ],
        ];

        if (!$this->validate($validationRule)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid file upload',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $img = $this->request->getFile('image');

        if ($img->isValid() && !$img->hasMoved()) {
            // Generate unique filename
            $newName = $img->getRandomName();

            try {
                // Move file to uploads directory
                $img->move(ROOTPATH . 'public/assets/images/uploads', $newName);

                // Return success response
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Image uploaded successfully',
                    'data' => [
                        'filename' => $newName,
                        'original_name' => $img->getClientName(),
                        'url' => base_url('assets/images/uploads/' . $newName)
                    ]
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to upload image: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'No file uploaded or file is invalid'
        ]);
    }
    public function delete()
    {
        // Check if user is admin
        if (!session()->get('admin_logged_in')) {
            return $this->failUnauthorized('Access denied');
        }

        // Try to get filename from JSON input first, then POST
        $json = $this->request->getJSON(true);
        $filename = $json['filename'] ?? $this->request->getPost('filename');

        if (empty($filename)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Filename is required'
            ]);
        }

        // Security check: only allow filenames without path traversal
        if (strpos($filename, '../') !== false || strpos($filename, '/') !== false || strpos($filename, '\\') !== false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid filename'
            ]);
        }

        $filePath = ROOTPATH . 'public/assets/images/uploads/' . $filename;

        if (file_exists($filePath)) {
            try {
                unlink($filePath);
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Image deleted successfully',
                    'filename' => $filename
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete image: ' . $e->getMessage()
                ]);
            }
        }

        return $this->response->setJSON([
            'status' => 'success', // Return success even if file doesn't exist
            'message' => 'File not found (already deleted)',
            'filename' => $filename
        ]);
    }
}
