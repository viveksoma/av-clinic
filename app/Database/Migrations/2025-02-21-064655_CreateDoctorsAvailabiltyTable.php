<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDoctorsAvailabiltyTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'doctor_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'day_of_week' => ['type' => 'VARCHAR', 'constraint' => 10], // e.g., Monday, Tuesday
            'morning_start' => ['type' => 'TIME', 'default' => '09:00'],
            'morning_end' => ['type' => 'TIME', 'default' => '13:00'],
            'evening_start' => ['type' => 'TIME', 'default' => '15:00'],
            'evening_end' => ['type' => 'TIME', 'default' => '21:00'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('doctor_id', 'doctors', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('doctor_availabilities');
    }

    public function down()
    {
        $this->forge->dropTable('doctor_availabilities');
    }
}
