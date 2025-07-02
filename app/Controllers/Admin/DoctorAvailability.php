<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DoctorAvailabilityModel;

class DoctorAvailability extends BaseController
{
    /**
     * Fetch weekly availability for a doctor (AJAX).
     */
    public function getAvailability($doctorId)
    {
        $model = new DoctorAvailabilityModel();
        $availability = $model->where('doctor_id', $doctorId)->findAll();
        return $this->response->setJSON($availability);
    }

    /**
     * Save/Update weekly availability for a doctor (AJAX POST).
     */
    public function updateAvailability()
    {
        $model = new DoctorAvailabilityModel();
        $doctorId = $this->request->getPost('doctor_id');
        $days = $this->request->getPost('availability'); // ✅ fixed

        // Clear existing
        $model->where('doctor_id', $doctorId)->delete();

        // Insert new
        foreach ($days as $day => $data) {
            $model->insert([
                'doctor_id' => $doctorId,
                'day_of_week' => $day,
                'morning_start' => $data['morning_start'] ?? null,
                'morning_end' => $data['morning_end'] ?? null,
                'evening_start' => $data['evening_start'] ?? null,
                'evening_end' => $data['evening_end'] ?? null,
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Availability updated successfully.'
        ]);
    }


}
