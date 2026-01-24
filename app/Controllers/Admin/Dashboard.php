<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Models\PatientVaccineModel;
use App\Models\PatientModel;
use Config\Database;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = [];

        $doctorModel = new DoctorModel();
        $data['doctors'] = $doctorModel->findAll();

        $appointmentModel = new AppointmentModel();
        $today = date('Y-m-d');

        // Today's appointments
        $data['appointments'] = $appointmentModel
            ->select('appointments.*, patients.name as patient_name, doctors.name as doctor_name')
            ->join('patients', 'patients.id = appointments.patient_id')
            ->join('doctors', 'doctors.id = appointments.doctor_id')
            ->where('appointment_date', $today)
            ->orderBy('start_time', 'ASC')
            ->findAll();

        // 🔥 Vaccine reminders (correct logic)
        $db = Database::connect();

    $sql = "
        SELECT
            p.id AS patient_id,
            p.name AS patient_name,
            p.phone,
            v.name AS vaccine_name,
            sv.dose_label,
            vs.stage_label,
            vs.age_in_days,

            DATE_ADD(p.dob, INTERVAL vs.age_in_days DAY) AS due_date,

            CASE
                WHEN DATE_ADD(p.dob, INTERVAL vs.age_in_days DAY) < CURDATE()
                    THEN 'Missed'
                ELSE 'Upcoming'
            END AS status

        FROM patients p

        /* Last taken vaccine (if any) */
        LEFT JOIN (
            SELECT
                pv.patient_id,
                MAX(vs.age_in_days) AS last_stage_days
            FROM patient_vaccines pv
            JOIN stage_vaccines sv ON sv.id = pv.stage_vaccine_id
            JOIN vaccination_stages vs ON vs.id = sv.vaccination_stage_id
            GROUP BY pv.patient_id
        ) last_vaccine ON last_vaccine.patient_id = p.id

        JOIN vaccination_stages vs
        JOIN stage_vaccines sv ON sv.vaccination_stage_id = vs.id
        JOIN vaccines v ON v.id = sv.vaccine_id

        LEFT JOIN patient_vaccines pv
            ON pv.patient_id = p.id
            AND pv.stage_vaccine_id = sv.id

        WHERE
            p.dob IS NOT NULL
            AND pv.id IS NULL

            /* 🔥 CORE LOGIC */
            AND (
                -- Existing patient → next vaccine after last taken
                (last_vaccine.last_stage_days IS NOT NULL
                    AND vs.age_in_days > last_vaccine.last_stage_days
                    AND vs.age_in_days = (
                        SELECT MIN(vs2.age_in_days)
                        FROM vaccination_stages vs2
                        WHERE vs2.age_in_days > last_vaccine.last_stage_days
                    )
                )

                OR

                -- New patient → last missed / due vaccine
                (last_vaccine.last_stage_days IS NULL
                    AND vs.age_in_days = (
                        SELECT MAX(vs3.age_in_days)
                        FROM vaccination_stages vs3
                        WHERE DATE_ADD(p.dob, INTERVAL vs3.age_in_days DAY) <= CURDATE()
                    )
                )
            )

            /* Show only due / upcoming (next 7 days) */
            AND DATE_ADD(p.dob, INTERVAL vs.age_in_days DAY)
                <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)

        ORDER BY due_date ASC
    ";


        $rows = $db->query($sql)->getResultArray();

        // 🔹 GROUP BY PATIENT
        $grouped = [];

        foreach ($rows as $r) {
            $pid = $r['patient_id'];

            if (!isset($grouped[$pid])) {
                $grouped[$pid] = [
                    'patient_name' => $r['patient_name'],
                    'phone'        => $r['phone'],
                    'vaccines'     => []
                ];
            }

            $grouped[$pid]['vaccines'][] = [
                'vaccine_name' => $r['vaccine_name'],
                'dose_label'   => $r['dose_label'] ?? '-',
                'stage_label'  => $r['stage_label'],
                'due_date'     => $r['due_date'],
                'status'       => $r['status']
            ];
        }

        $data['vaccineReminders'] = $grouped;

        return view('admin/dashboard', $data);
    }

}
