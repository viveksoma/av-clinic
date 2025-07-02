<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PatientModel;

class PatientVaccines extends BaseController
{
    /**
     * GET /admin/patient-vaccines/{id}
     * - If no vaccine records: return only patient data
     * - If vaccine records exist: return patient + vaccines
     */
    public function show($patientId)
    {
        $db           = \Config\Database::connect();
        $patientModel = new PatientModel();

        // 1) Load patient
        $patient = $patientModel->find($patientId);
        if (! $patient) {
            return $this->response
                        ->setStatusCode(404)
                        ->setJSON(['error' => 'Patient not found']);
        }

        // Calculate age from DOB, if you have dob field:
        if (! empty($patient['dob'])) {
            $dob = new \DateTime($patient['dob']);
            $now = new \DateTime();
            $diff = $now->diff($dob);
            $patient['age'] = $diff->y . 'y ' . $diff->m . 'm';
        }

        // 2) Fetch vaccine records
        $builder = $db->table('patient_vaccines');
        $builder->select('vaccine_name, dose_number, vaccination_date');
        $builder->where('patient_id', $patientId);
        $builder->orderBy('vaccination_date', 'ASC');
        $vaccines = $builder->get()->getResultArray();

        // 3) Build response
        $payload = [
            'patient' => [
                'id'     => $patient['id'],
                'name'   => $patient['name'],
                'gender' => $patient['gender'] ?? null,
                'dob'    => $patient['dob'] ?? null,
                'age'    => $patient['age'] ?? null,
                'phone'  => $patient['phone'] ?? null,
                'email'  => $patient['email'] ?? null,
            ]
        ];

        if (count($vaccines) > 0) {
            $payload['vaccines'] = $vaccines;
        }

        return $this->response->setJSON($payload);
    }


    /**
     * POST /admin/patient-vaccines/add
     * - If patient_id is missing or invalid: first create a new patient
     * - Then insert one or more vaccine doses
     */
    public function add()
    {
        $db           = \Config\Database::connect();
        $patientModel = new PatientModel();

        $patientId = $this->request->getPost('patient_id');

        // If no patient_id sent, create a new patient record
        if (! $patientId) {
            $newData = [
                'name'   => $this->request->getPost('name'),
                'age'    => $this->request->getPost('age'),
                'phone'  => $this->request->getPost('phone_number'),
                'email'  => $this->request->getPost('email'),
                'dob'    => $this->request->getPost('dob'),
                'gender' => $this->request->getPost('gender'),
            ];
            $patientId = $patientModel->insert($newData);

            if (! $patientId) {
                return $this->response
                            ->setStatusCode(500)
                            ->setJSON(['error' => 'Failed to create patient']);
            }
        }

        // Now insert the vaccine doses
        $vaccineNames     = $this->request->getPost('vaccine_name');
        $doseNumbers      = $this->request->getPost('dose_number');
        $vaccinationDates = $this->request->getPost('vaccination_date');

        if (! is_array($vaccineNames) || count($vaccineNames) === 0) {
            return $this->response
                        ->setStatusCode(400)
                        ->setJSON(['error' => 'No vaccine data provided']);
        }

        foreach ($vaccineNames as $i => $vaccine) {
            $db->table('patient_vaccines')->insert([
                'patient_id'       => $patientId,
                'vaccine_name'     => $vaccine,
                'dose_number'      => $doseNumbers[$i],
                'vaccination_date' => $vaccinationDates[$i],
                'created_at'       => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->response->setJSON([
            'status'     => 'success',
            'patient_id' => $patientId
        ]);
    }
}
