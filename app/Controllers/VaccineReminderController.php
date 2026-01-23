<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class VaccineReminderController extends Controller
{
    public function sendReminders()
    {
        helper(['email', 'date']);

        $db = Database::connect();
        $today = date('Y-m-d');

        // Reminder windows
        $reminderMap = [
            '7_days'   => 7,
            '3_days'   => 3,
            'same_day' => 0
        ];

        $emailsSent = 0;

        foreach ($reminderMap as $type => $daysBefore) {

            $sql = "
                SELECT
                    p.id AS patient_id,
                    p.name AS patient_name,
                    p.email,
                    sv.id AS stage_vaccine_id,
                    v.name AS vaccine_name,
                    sv.dose_label,
                    DATE_ADD(p.dob, INTERVAL vs.age_in_days DAY) AS due_date
                FROM patients p
                JOIN stage_vaccines sv
                JOIN vaccination_stages vs ON vs.id = sv.vaccination_stage_id
                JOIN vaccines v ON v.id = sv.vaccine_id
                LEFT JOIN patient_vaccines pv
                    ON pv.patient_id = p.id
                    AND pv.stage_vaccine_id = sv.id
                LEFT JOIN vaccine_reminder_logs rl
                    ON rl.patient_id = p.id
                    AND rl.stage_vaccine_id = sv.id
                    AND rl.reminder_type = ?
                WHERE
                    p.email IS NOT NULL
                    AND p.dob IS NOT NULL
                    AND pv.id IS NULL
                    AND rl.id IS NULL
                    AND DATE_ADD(p.dob, INTERVAL vs.age_in_days DAY)
                        = DATE_ADD(?, INTERVAL ? DAY)
            ";

            $rows = $db->query($sql, [$type, $today, $daysBefore])->getResultArray();

            // 🔹 GROUP BY PATIENT
            $grouped = [];

            foreach ($rows as $row) {
                $pid = $row['patient_id'];

                if (!isset($grouped[$pid])) {
                    $grouped[$pid] = [
                        'patient_id'   => $pid,
                        'patient_name' => $row['patient_name'],
                        'email'        => $row['email'],
                        'vaccines'     => []
                    ];
                }

                $grouped[$pid]['vaccines'][] = [
                    'stage_vaccine_id' => $row['stage_vaccine_id'],
                    'vaccine_name'     => $row['vaccine_name'],
                    'dose_label'       => $row['dose_label'] ?? '-',
                    'due_date'         => $row['due_date']
                ];
            }

            // 🔹 SEND ONE EMAIL PER PATIENT
            foreach ($grouped as $patient) {

                $sent = sendGroupedVaccineReminderEmail(
                    $patient['email'],
                    $patient['patient_name'],
                    $patient['vaccines'],
                    $type
                );

                if ($sent) {
                    $emailsSent++;

                    // 🔹 LOG EACH DOSE (IMPORTANT)
                    foreach ($patient['vaccines'] as $vaccine) {
                        $db->table('vaccine_reminder_logs')->insert([
                            'patient_id'       => $patient['patient_id'],
                            'stage_vaccine_id' => $vaccine['stage_vaccine_id'],
                            'reminder_type'    => $type
                        ]);
                    }
                }
            }
        }

        return $this->response->setJSON([
            'status'      => 'completed',
            'emails_sent' => $emailsSent
        ]);
    }
}
