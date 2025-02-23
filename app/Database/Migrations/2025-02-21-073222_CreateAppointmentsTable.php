<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'doctor_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'patient_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'appointment_date' => ['type' => 'DATE'],
            'start_time' => ['type' => 'TIME'],
            'status' => ['type' => 'ENUM', 'constraint' => ['Scheduled', 'Completed', 'Cancelled'], 'default' => 'Scheduled'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('doctor_id', 'doctors', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('appointments');
    }

    public function down()
    {
        $this->forge->dropTable('appointments');
    }
}
