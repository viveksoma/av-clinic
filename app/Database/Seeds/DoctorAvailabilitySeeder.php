<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DoctorAvailabilitySeeder extends Seeder
{
    public function run()
    {
        $data = [];

        // Sample data for 3 doctors, for each day of the week
        $doctors = [1, 2]; // Replace with actual doctor IDs
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($doctors as $doctorId) {
            foreach ($days as $day) {
                $data[] = [
                    'doctor_id'     => $doctorId,
                    'day_of_week'   => $day,
                    'morning_start' => '09:00:00',
                    'morning_end'   => '13:00:00',
                    'evening_start' => '15:00:00',
                    'evening_end'   => '21:00:00',
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ];
            }
        }

        // Insert data into the database
        $this->db->table('doctor_availabilities')->insertBatch($data);
    }
}
