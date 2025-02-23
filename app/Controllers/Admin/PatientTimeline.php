<?php

namespace App\Controllers\Admin;
use App\Models\DoctorModel;
use App\Controllers\BaseController;

class PatientTimeline extends BaseController
{
    public function index(): string
    {
        $data = array();
        $doctorModel = new DoctorModel();
        $data['doctors'] = $doctorModel->findAll();

        return view('admin/patient_timeline', $data);  // Correct method to load view in CI4
    }

}
