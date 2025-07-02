<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\PatientVaccineModel;
use App\Models\PatientModel;

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

        $reminders = $patientVaccineModel
            ->select('patient_vaccines.*, patients.name as patient_name, patients.phone as phone, patients.age')
            ->join('patients', 'patients.id = patient_vaccines.patient_id')
            ->where('vaccination_date >=', $today)
            ->where('vaccination_date <=', $nextWeek)
            ->orderBy('vaccination_date', 'ASC')
            ->findAll();

        $data['vaccineReminders'] = $reminders;
        return view('admin/dashboard', $data);  // Correct method to load view in CI4
    }

}
