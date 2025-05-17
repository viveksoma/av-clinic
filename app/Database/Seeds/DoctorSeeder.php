<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Dr. John Doe', 'specialization' => 'Cardiology'],
            ['name' => 'Dr. Jane Smith', 'specialization' => 'Dermatology']
        ];
        $this->db->table('doctors')->insertBatch($data);
    }
}
?>