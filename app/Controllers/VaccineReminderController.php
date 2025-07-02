<?php

namespace App\Controllers;

use App\Models\PatientVaccineModel;
use CodeIgniter\Controller;

class VaccineReminderController extends Controller
{
    public function sendReminders()
    {
        helper(['email', 'date']);  // Load email helper (with your custom sendVaccineReminderEmail)

        $today = date('Y-m-d');
        $nextWeek = date('Y-m-d', strtotime('+7 days'));

        $model = new PatientVaccineModel();
        
        $upcomingVaccines = $model
            ->select('patient_vaccines.*, patients.name as patient_name, patients.email')
            ->join('patients', 'patients.id = patient_vaccines.patient_id')
            ->where('vaccination_date >=', $today)
            ->where('vaccination_date <=', $nextWeek)
            ->findAll();

        $emailsSent = 0;

        foreach ($upcomingVaccines as $row) {
            if (!empty($row['email'])) {
                $success = sendVaccineReminderEmail(
                    $row['email'],
                    $row['patient_name'],
                    $row['vaccine_name'],
                    $row['dose_number'],
                    $row['vaccination_date']
                );

                if ($success) {
                    $emailsSent++;
                }
            }
        }

        return $this->response->setJSON([
            'status' => 'completed',
            'total' => count($upcomingVaccines),
            'emails_sent' => $emailsSent
        ]);
    }
}
