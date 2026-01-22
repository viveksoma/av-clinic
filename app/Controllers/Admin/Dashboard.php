<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\PatientVaccineModel;
use App\Models\PatientModel;
use Config\Database;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = array();
        $doctorModel = new DoctorModel();
        $data['doctors'] = $doctorModel->findAll();
        $appointmentModel = new AppointmentModel();

        // Get today's date
        $today = date('Y-m-d');

        // Fetch today's appointments sorted by slot time
        $appointments = $appointmentModel
            ->select('appointments.*, patients.name as patient_name, doctors.name as doctor_name')
            ->join('patients', 'patients.id = appointments.patient_id')
            ->join('doctors', 'doctors.id = appointments.doctor_id')
            ->where('appointment_date', $today)
            ->orderBy('start_time', 'ASC') // Sorting by slot time
            ->findAll();
        $data['appointments'] = $appointments;

        // ✅ Fetch upcoming vaccine reminders (next 7 days)
        $patientVaccineModel = new PatientVaccineModel();
        $nextWeek = date('Y-m-d', strtotime('+7 days'));

        $db = Database::connect();

        $sql = "
            SELECT
                p.id AS patient_id,
                p.name AS patient_name,
                p.phone,
                p.dob,
                v.name AS vaccine_name,
                sv.dose_label,
                vs.stage_label,
                vs.age_in_days,
                DATE_ADD(p.dob, INTERVAL vs.age_in_days DAY) AS due_date
            FROM patients p
            JOIN stage_vaccines sv ON 1=1
            JOIN vaccination_stages vs ON vs.id = sv.vaccination_stage_id
            JOIN vaccines v ON v.id = sv.vaccine_id
            LEFT JOIN patient_vaccines pv
                ON pv.patient_id = p.id
                AND pv.stage_vaccine_id = sv.id
            WHERE
                p.dob IS NOT NULL
                AND pv.id IS NULL
                AND DATE_ADD(p.dob, INTERVAL vs.age_in_days DAY)
                    <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
            ORDER BY due_date ASC
            LIMIT 50
        ";

        $data['vaccineReminders'] = $db->query($sql)->getResultArray();
        return view('admin/dashboard', $data);  // Correct method to load view in CI4
    }

}
