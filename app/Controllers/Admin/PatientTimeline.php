<?php

namespace App\Controllers\Admin;
use App\Models\DoctorModel;
use App\Models\VaccineModel;
use App\Controllers\BaseController;

class PatientTimeline extends BaseController
{
    public function index(): string
    {
        $data = array();
        $doctorModel = new DoctorModel();
        $vaccineModel = new VaccineModel();
        $data['doctors'] = $doctorModel->findAll();
        $data['vaccines'] = $vaccineModel->findAll();

        return view('admin/patient_timeline', $data);  // Correct method to load view in CI4
    }

}
