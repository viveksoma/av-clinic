<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\VaccineModel;


class Vaccines extends BaseController
{
    public function index(): string
    {
        $vaccineModel = new VaccineModel();
        $data['vaccines'] = $vaccineModel->findAll();

        return view('admin/vaccines', $data);
    }

    public function show($patientId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('patient_vaccines');
        $builder->select('vaccine_name, dose_number, vaccination_date');
        $builder->where('patient_id', $patientId);
        $builder->orderBy('vaccination_date', 'ASC');

        $result = $builder->get()->getResult();

        return $this->response->setJSON($result);
    }

    // POST: /admin/patient-vaccines/add
    public function add()
    {
        $db = \Config\Database::connect();

        $patientId = $this->request->getPost('patient_id');
        $vaccineNames = $this->request->getPost('vaccine_name');
        $doseNumbers = $this->request->getPost('dose_number');
        $vaccinationDates = $this->request->getPost('vaccination_date');

        if (!$patientId || !is_array($vaccineNames)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid data']);
        }

        foreach ($vaccineNames as $i => $vaccine) {
            $data = [
                'patient_id' => $patientId,
                'vaccine_name' => $vaccine,
                'dose_number' => $doseNumbers[$i],
                'vaccination_date' => $vaccinationDates[$i],
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $db->table('patient_vaccines')->insert($data);
        }

        return $this->response->setJSON(['status' => 'success']);
    }

}
