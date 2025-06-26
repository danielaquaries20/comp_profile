<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageFieldsToCompanySettings extends Migration
{
    public function up()
    {
          // Update setting_type enum to include 'image' type
        $this->forge->modifyColumn('company_settings', [
            'setting_type' => [
                'type' => 'ENUM',
                'constraint' => ['text', 'textarea', 'email', 'phone', 'json', 'image'],
                'default' => 'text',
            ]
        ]);
    }

    public function down()
    {
        // Revert setting_type enum to original values
        $this->forge->modifyColumn('company_settings', [
            'setting_type' => [
                'type' => 'ENUM',
                'constraint' => ['text', 'textarea', 'email', 'phone', 'json'],
                'default' => 'text',
            ]
        ]);
    }
}
