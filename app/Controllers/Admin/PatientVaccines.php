<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PatientModel;

class PatientVaccines extends BaseController
{
    /**
     * GET /admin/patient-vaccines/{id}
     */
    public function show($patientId)
    {
        $db = \Config\Database::connect();
        $patient = (new PatientModel())->find($patientId);

        if (!$patient) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['error' => 'Patient not found']);
        }

        $sql = "
            SELECT
                vs.stage_label,
                vs.id AS vaccination_stage_id,
                v.name AS vaccine_name,
                sv.id AS stage_vaccine_id,
                sv.dose_label,
                pv.given_date,
                CASE
                    WHEN pv.id IS NOT NULL THEN 'given'
                    ELSE 'pending'
                END AS status
            FROM stage_vaccines sv
            JOIN vaccination_stages vs ON vs.id = sv.vaccination_stage_id
            JOIN vaccines v ON v.id = sv.vaccine_id
            LEFT JOIN patient_vaccines pv
                ON pv.stage_vaccine_id = sv.id
                AND pv.patient_id = ?
            ORDER BY vs.display_order, sv.display_order
        ";

        $doses = $db->query($sql, [$patientId])->getResultArray();

        return $this->response->setJSON([
            'patient' => $patient,
            'doses'   => $doses
        ]);
    }

    /**
     * POST /admin/patient-vaccines/add
     * Stage-wise mark given
     */
    public function add()
    {
        $patientId = $this->request->getPost('patient_id');
        $stageId   = $this->request->getPost('vaccination_stage_id');

        if (!$patientId || !$stageId) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['error' => 'Invalid request']);
        }

        $db = \Config\Database::connect();

        $stageVaccines = $db->table('stage_vaccines')
            ->where('vaccination_stage_id', $stageId)
            ->get()
            ->getResultArray();

        foreach ($stageVaccines as $sv) {

            $exists = $db->table('patient_vaccines')
                ->where([
                    'patient_id' => $patientId,
                    'stage_vaccine_id' => $sv['id']
                ])
                ->get()
                ->getRow();

            if ($exists) continue;

            $db->table('patient_vaccines')->insert([
                'patient_id'       => $patientId,
                'stage_vaccine_id' => $sv['id'],
                'given_date'       => date('Y-m-d'),
                'status'           => 'given'
            ]);
        }

        return $this->response->setJSON(['status' => 'success']);
    }
}
