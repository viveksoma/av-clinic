<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDoctorsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'specialization' => ['type' => 'VARCHAR', 'constraint' => 255],
            'slot_duration' => ['type' => 'INT', 'constraint' => 5, 'default' => 15], // in minutes
            'profile_pic' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('doctors');
    }

    public function down()
    {
        $this->forge->dropTable('doctors');
    }
}
