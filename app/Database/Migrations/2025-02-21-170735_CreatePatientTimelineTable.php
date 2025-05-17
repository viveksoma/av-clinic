<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatientTimelineTable extends Migration
{
    public function up()
    {
        // Creating the 'patient_timeline' table
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'patient_id'    => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'text'          => [
                'type'       => 'TEXT',
                'null'       => false,
            ],
            'title'          => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'file'          => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'doctor_id'     => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Adding the primary key
        $this->forge->addPrimaryKey('id');

        // Adding foreign key relationships
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('doctor_id', 'doctors', 'id', 'CASCADE', 'CASCADE');

        // Create the table
        $this->forge->createTable('patient_timeline');
    }

    public function down()
    {
        // Dropping the table
        $this->forge->dropTable('patient_timeline');
    }
}
