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
        $doctorName     = $this->request->getPost('doctor_name');
        $specialization = $this->request->getPost('specialization');
        $slotDuration   = $this->request->getPost('slot_duration');

        // Handle Profile Pic Upload
        $profilePic = $this->request->getFile('profile_pic');
        $profilePicName = null;

        if ($profilePic && $profilePic->isValid() && !$profilePic->hasMoved()) {
            // Clean file name (remove spaces, special characters)
            $originalName = $profilePic->getClientName();
            $cleanName = preg_replace('/[^A-Za-z0-9\-.]/', '', str_replace(' ', '-', $originalName));

            // Add timestamp to make filename unique
            $profilePicName = time() . '-' . $cleanName;

            // Move to public/uploads directory
            $profilePic->move('uploads', $profilePicName);
        }

        // Prepare data for insertion
        $data = [
            'name'          => $doctorName,
            'specialization'=> $specialization,
            'slot_duration' => $slotDuration,
            'profile_pic'   => $profilePicName,
        ];

        // Insert the new doctor into the database
        $doctorModel->insert($data);

        return redirect()->to('admin/doctors')->with('message', 'Doctor created successfully!');
    }

}
