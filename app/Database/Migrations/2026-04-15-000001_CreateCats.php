<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCats extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cat_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true, // Directly add unique here if supported, or via addUniqueKey
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'breed' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'gender' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
            ],
            'age' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'color' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
            ],
            'is_spayed' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'favorite_food' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('cat_id'); // Explicitly adding the unique constraint
        $this->forge->createTable('cats');
    }

    public function down()
    {
        $this->forge->dropTable('cats');
    }
}
