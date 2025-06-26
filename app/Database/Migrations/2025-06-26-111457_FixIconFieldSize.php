<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixIconFieldSize extends Migration
{
    public function up()
    {
        // Alter field icon di tabel services untuk menampung class Font Awesome yang lebih panjang
        $this->forge->modifyColumn('services', [
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'comment' => 'Font Awesome icon class'
            ]
        ]);
    }

    public function down()
    {
        // Kembalikan ke ukuran semula
        $this->forge->modifyColumn('services', [
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false
            ]
        ]);
    }
}
