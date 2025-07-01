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

        $doctorId      = $this->request->getPost('doctor_id');
        $doctorName    = $this->request->getPost('doctor_name');
        $doctorEmail    = $this->request->getPost('doctor_email');
        $specialization= $this->request->getPost('specialization');
        $slotDuration  = $this->request->getPost('slot_duration');
        $qualifications= $this->request->getPost('qualifications');
        $about         = $this->request->getPost('about'); // from Summernote
        $socialLinks   = $this->request->getPost('social_links');
        // print_r($doctorEmail);
        // exit;

        $profilePic = $this->request->getFile('profile_pic');
        $profilePicName = null;

        // Handle file upload if any
        if ($profilePic && $profilePic->isValid() && !$profilePic->hasMoved()) {
            $cleanName = preg_replace('/[^A-Za-z0-9\-.]/', '', str_replace(' ', '-', $doctorName));
            $profilePicName = time() . '-' . $cleanName;
            $profilePic->move('uploads', $profilePicName);
        }

        // Prepare data
        $data = [
            'name'           => $doctorName,
            'email'          => $doctorEmail,
            'specialization' => $specialization,
            'slot_duration'  => $slotDuration,
            'qualifications' => $qualifications,
            'about'          => $about,
            'social_links'   => json_encode($socialLinks), // JSON encode
        ];

        // Only set profile_pic if uploaded
        if ($profilePicName) {
            $data['profile_pic'] = $profilePicName;
        }

        if ($doctorId) {
            // Update
            $doctorModel->update($doctorId, $data);
            return redirect()->to('admin/doctors')->with('message', 'Doctor updated successfully!');
        } else {
            // Insert
            $doctorModel->insert($data);
            return redirect()->to('admin/doctors')->with('message', 'Doctor created successfully!');
        }
    }


}
