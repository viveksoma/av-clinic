<?php

namespace App\Controllers\Main;

use App\Controllers\BaseController;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;

class Home extends BaseController
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
        return view('main/home', $data);  // Correct method to load view in CI4
    }
}
