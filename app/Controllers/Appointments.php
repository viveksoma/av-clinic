<?php
namespace App\Controllers;

use App\Models\DoctorModel;
use App\Models\AppointmentModel;

class Appointments extends BaseController
{
    public function booking()
    {
        $doctorModel = new DoctorModel();
        $data['doctors'] = $doctorModel->findAll();

        return view('appointments/booking', $data);
    }

    public function getSlots()
    {
        $doctor_id = $this->request->getGet('doctor_id');
        $date = $this->request->getGet('date');

        $appointmentModel = new AppointmentModel();
        $slots = $appointmentModel->getAvailableSlots($doctor_id, $date);

        return $this->response->setJSON($slots);
    }

    public function getDoctorAvailableDays()
    {
        $doctor_id = $this->request->getGet('doctor_id');
        $DoctorAvailabilityModel = new \App\Models\DoctorAvailabilityModel();

        $availability = $DoctorAvailabilityModel
            ->select('day_of_week')
            ->where('doctor_id', $doctor_id)
            ->groupBy('day_of_week')
            ->findAll();

        $days = array_column($availability, 'day_of_week');

        return $this->response->setJSON([
            'available_days' => $days
        ]);
    }

    public function book()
    {
        try {
            helper('email');

            $doctor_id        = $this->request->getPost('doctor_id');
            $date             = $this->request->getPost('date');
            $time             = $this->request->getPost('time');
            $phone_number     = $this->request->getPost('phone_number');
            $appointment_type = $this->request->getPost('appointment_type');
            $patient_id       = $this->request->getPost('patient_id');

            if (!$doctor_id || !$date || !$time || !$phone_number || !$appointment_type) {
                return $this->response->setJSON(['message' => 'Missing required fields.'], 400);
            }

            $patientModel = new \App\Models\PatientModel();

            /** -------------------------
             *  CASE 1: Existing Patient
             *  ------------------------- */
            if (!empty($patient_id)) {

                $patient = $patientModel
                    ->where('id', $patient_id)
                    ->where('phone', $phone_number)
                    ->first();

                if (!$patient) {
                    return $this->response->setJSON([
                        'message' => 'Invalid patient selection.'
                    ], 400);
                }

            }
            /** -------------------------
             *  CASE 2: Add New Patient
             *  ------------------------- */
            else {

                $name = $this->request->getPost('patient_name');
                $age  = $this->request->getPost('patient_age');

                if (!$name || !$age) {
                    return $this->response->setJSON([
                        'message' => 'Patient name and age are required.'
                    ], 400);
                }

                // Guardian required if age < 18
                if ($age < 18) {
                    if (
                        !$this->request->getPost('guardian_name') ||
                        !$this->request->getPost('guardian_relation')
                    ) {
                        return $this->response->setJSON([
                            'message' => 'Guardian details required for minors.'
                        ], 400);
                    }
                }

                $patientData = [
                    'name'              => $name,
                    'age'               => $age,
                    'phone'             => $phone_number,
                    'email'             => $this->request->getPost('email'),
                    'dob'             => $this->request->getPost('dob'),
                    'guardian_name'     => $this->request->getPost('guardian_name'),
                    'guardian_relation' => $this->request->getPost('guardian_relation')
                ];

                $patient_id = $patientModel->insert($patientData);

                if (!$patient_id) {
                    return $this->response->setJSON([
                        'error' => 'Failed to create patient.'
                    ], 500);
                }

                $patient = $patientModel->find($patient_id);
            }

            /** -------------------------
             *  Appointment Conflict Check
             *  ------------------------- */
            $appointmentModel = new \App\Models\AppointmentModel();

            $existingAppointment = $appointmentModel
                ->where('doctor_id', $doctor_id)
                ->where('appointment_date', $date)
                ->where('start_time', $time)
                ->first();

            if ($existingAppointment) {
                return $this->response->setJSON([
                    'message' => 'Appointment already exists at this time.'
                ], 400);
            }

            /** -------------------------
             *  Create Appointment
             *  ------------------------- */
            $data = [
                'doctor_id'        => $doctor_id,
                'appointment_date' => $date,
                'start_time'       => $time,
                'status'           => 'Scheduled',
                'patient_id'       => $patient['id'],
                'appointment_type' => $appointment_type,
                'google_meet_link' => null
            ];

            if (!$appointmentModel->insert($data)) {
                return $this->response->setJSON([
                    'error' => 'Failed to book appointment.'
                ], 500);
            }

            if (!empty($patient['email'])) {
                sendAppointmentEmail(
                    $patient['email'],
                    $date,
                    $time,
                    $appointment_type,
                );
            }

            if (strtolower($appointment_type) === 'online') {
                $doctorModel = new \App\Models\DoctorModel();
                $doctor = $doctorModel->find($doctor_id);

                $doctorName = $doctor ? $doctor['name'] : 'N/A';

                sendOnlineAppointmentNotification(
                    $patient['name'],
                    $patient['phone'],
                    $doctorName, // pass actual doctor name
                    $date,
                    $time,
                    $appointment_type
                );
            }

            return $this->response->setJSON([
                'message' => 'Appointment booked successfully!'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error booking appointment: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Internal server error.'
            ], 500);
        }
    }

    public function getBookedSlots()
    {
        $doctor_id = $this->request->getGet('doctor_id');
        $date = $this->request->getGet('date');

        // Get all booked slots for the doctor and date
        
        $appointmentModel = new AppointmentModel();
        $bookedTimes = $appointmentModel->getBookedSlots($doctor_id, $date);
        // Return the booked slots in the response
        return $this->response->setJSON(['booked_slots' => $bookedTimes]);
    }
    
}
?>