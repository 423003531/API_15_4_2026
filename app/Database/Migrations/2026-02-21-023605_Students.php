<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Students extends Migration
{
    public function up()
    {
        // Define the table structure
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                ],
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'unique'     => true,
                ],
                'course' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                ],
                'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            ]);

            $this->forge->addKey('id', true); // Primary Key
            $this->forge->createTable('students'); // Create the table
    
    }

    public function down()
    {
    
        // Drop the table if we need to rollback
        $this->forge->dropTable('students');

    }
}
