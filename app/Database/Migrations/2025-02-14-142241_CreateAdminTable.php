<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'email'    => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
            'username'    => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
            'password' => ['type' => 'VARCHAR', 'constraint' => '255'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('admins');
    }

    public function down()
    {
        $this->forge->dropTable('admins');
    }
}
