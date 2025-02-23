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

    public function book()
    {
        try {
            // Get data from POST
            $doctor_id = $this->request->getPost('doctor_id');
            $date = $this->request->getPost('date');
            $time = $this->request->getPost('time');
            $phone_number = $this->request->getPost('phone_number');

            if (!$doctor_id || !$date || !$time || !$phone_number) {
                return $this->response->setJSON(['message' => 'Missing required fields.'], 400);
            }

            // Load PatientModel
            $patientModel = new \App\Models\PatientModel();
            $patient = $patientModel->where('phone', $phone_number)->first();

            if (!$patient) {
                $patientData = [
                    'name' => $this->request->getPost('patient_name'),
                    'age' => $this->request->getPost('patient_name'),
                    'phone' => $phone_number
                ];
                $patientId = $patientModel->insert($patientData);
                if (!$patientId) {
                    log_message('error', 'Failed to insert patient record');
                    return $this->response->setJSON(['error' => 'Failed to create patient.'], 500);
                }
                $patient = $patientModel->find($patientId);
            }

            // Load AppointmentModel
            $appointmentModel = new AppointmentModel();

            // Check for duplicate appointment
            $existingAppointment = $appointmentModel->where('doctor_id', $doctor_id)
                ->where('appointment_date', $date)
                ->where('start_time', $time)
                ->first();

            if ($existingAppointment) {
                return $this->response->setJSON(['message' => 'Appointment already exists at this time.'], 400);
            }

            // Insert appointment
            $data = [
                'doctor_id' => $doctor_id,
                'appointment_date' => $date,
                'start_time' => $time,
                'status' => 'Scheduled',
                'patient_id' => $patient['id']
            ];

            if (!$appointmentModel->insert($data)) {
                log_message('error', 'Failed to insert appointment record');
                return $this->response->setJSON(['error' => 'Failed to book appointment.'], 500);
            }

            return $this->response->setJSON(['message' => 'Appointment booked successfully!']);

        } catch (\Exception $e) {
            log_message('error', 'Error booking appointment: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Internal server error.'], 500);
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