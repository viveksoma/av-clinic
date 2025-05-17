<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;

class Doctors extends BaseController
{
    public function index(): string
    {
        $data = array();
        $doctorModel = new DoctorModel();
        $data['doctors'] = $doctorModel->findAll();

        return view('admin/doctors', $data);  // Correct method to load view in CI4
    }

    public function store()
    {
        $doctorModel = new DoctorModel();
        
        // Get form data
        $doctorName = $this->request->getPost('doctor_name');
        $specialization = $this->request->getPost('specialization');
        $slotDuration = $this->request->getPost('slot_duration');
        
        // Profile Pic Upload
        $profilePic = $this->request->getFile('profile_pic');
        
        // Move file to the 'uploads' folder (you need to create an 'uploads' folder inside public/)
        $profilePic->move('uploads', $profilePic->getName());

        // Prepare data for insertion
        $data = [
            'name' => $doctorName,
            'specialization' => $specialization,
            'slot_duration' => $slotDuration,
            'profile_pic' => $profilePic->getName(),
        ];

        // Insert the new doctor into the database
        $doctorModel->insert($data);

        return redirect()->to('admin/doctors')->with('message', 'Doctor created successfully!');
    }

}
