<?php

namespace App\Controllers\Main;

use App\Controllers\BaseController;
use App\Models\DoctorModel;

class Doctor extends BaseController
{
    public function index(): string
    {
        $data = array();
        $doctorModel = new DoctorModel();
        $data['doctors'] = $doctorModel->findAll();
        return view('main/doctor', $data);  // Correct method to load view in CI4
    }

    public function view($id)
    {
        $doctorModel = new \App\Models\DoctorModel();
        $doctor = $doctorModel->find($id);

        if (!$doctor) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Doctor not found");
        }

        $doctor['social_links'] = json_decode($doctor['social_links'], true);

        return view('main/doctor_single', ['doctor' => $doctor]);
    }

}
