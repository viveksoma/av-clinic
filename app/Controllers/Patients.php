<?php

namespace App\Controllers;

class Patients extends BaseController
{
    public function createPatient()
    {
        $patientModel = new \App\Models\PatientModel();
        $patientData = [
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age'),
            'phone' => $this->request->getPost('phone_number'),
            'email' => $this->request->getPost('email')
        ];

        // Insert new patient data
        $patientId = $patientModel->insert($patientData);
        
        if ($patientId) {
            return $this->response->setJSON(['patient_id' => $patientId]);
        } else {
            return $this->response->setJSON(['error' => 'Failed to create patient']);
        }
    }

    public function checkPatient()
    {
        try {
            $phone_number = $this->request->getGet('phone_number');

            if (!$phone_number) {
                return $this->response->setJSON([
                    'exists' => false,
                    'patients' => []
                ]);
            }

            $patientModel = new \App\Models\PatientModel();

            // EXECUTE the query
            $patients = $patientModel
                ->where('phone', $phone_number)
                ->findAll();

            if (!empty($patients)) {
                return $this->response->setJSON([
                    'exists' => true,
                    'patients' => $patients
                ]);
            }

            return $this->response->setJSON([
                'exists' => false,
                'patients' => []
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error checking patient: ' . $e->getMessage());

            return $this->response->setJSON([
                'error' => 'Unexpected error occurred',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function getPatientTimeline($patientId)
    {
        $PatientTimelineModel = new \App\Models\Admin\PatientTimelineModel();
        $timeline = $PatientTimelineModel
            ->select('patient_timeline.*, doctors.name as doctor_name')  // Select the doctor name along with the timeline fields
            ->join('doctors', 'doctors.id = patient_timeline.doctor_id', 'left')  // Join the doctors table on doctor_id
            ->where('patient_id', $patientId)
            ->findAll();
        
        return $this->response->setJSON(['timeline' => $timeline]);
        
    }

    // Add a new timeline event
    public function addTimelineEntry()
    {
        $patientId = $this->request->getPost('patient_id');
        $text = $this->request->getPost('text');
        $title = $this->request->getPost('title');
        $file = $this->request->getFile('file');
        $doctorId = $this->request->getPost('doctorId');

        if (!$patientId || !$text || !$title) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing data.']);
        }

        // Handle file upload if present
        $filePath = null;
        if ($file && $file->isValid()) {
            $filePath = $file->store();  // Save the file in the uploads folder
        }

        // Prepare data for insertion
        $PatientsTimelineModel = new \App\Models\Admin\PatientTimelineModel();
        $data = [
            'patient_id' => $patientId,
            'text' => $text,
            'title' => $title,
            'file' => $filePath,
            'doctor_id' => $doctorId,  // You can replace this with the actual user
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Insert into the database
        if ($PatientsTimelineModel->insert($data)) {
            $newEvent = $PatientsTimelineModel->find($PatientsTimelineModel->insertID());
            return $this->response->setJSON(['success' => true, 'event' => $newEvent]);
        } else {
            print_r($PatientsTimelineModel->errors());
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to add event.', 'error' => $PatientsTimelineModel->errors()]);
        }
    }
    public function search()
    {
        // Get patientId from query string
        $patientId = $this->request->getGet('patientId');

        // Initialize the PatientModel
        $patientModel = new \App\Models\PatientModel();

        // Search for patient by ID
        $patient = $patientModel->where('id', $patientId)->first();

        if ($patient) {
            return $this->response->setJSON(['patient' => $patient]);
        } else {
            return $this->response->setJSON(['patient' => null]);
        }
    }


}
