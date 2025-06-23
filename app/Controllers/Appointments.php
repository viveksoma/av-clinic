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
        {
            try {
                $doctor_id = $this->request->getPost('doctor_id');
                $date = $this->request->getPost('date');
                $time = $this->request->getPost('time');
                $phone_number = $this->request->getPost('phone_number');
                $appointment_type = $this->request->getPost('appointment_type');
        
                if (!$doctor_id || !$date || !$time || !$phone_number || !$appointment_type) {
                    return $this->response->setJSON(['message' => 'Missing required fields.'], 400);
                }
        
                $patientModel = new \App\Models\PatientModel();
                $patient = $patientModel->where('phone', $phone_number)->first();
        
                if (!$patient) {
                    $patientData = [
                        'name' => $this->request->getPost('patient_name'),
                        'age' => $this->request->getPost('patient_age'), // Fixed field
                        'phone' => $phone_number,
                        'email' => $this->request->getPost('email') // Optional email
                    ];
                    $patientId = $patientModel->insert($patientData);
                    if (!$patientId) {
                        log_message('error', 'Failed to insert patient record');
                        return $this->response->setJSON(['error' => 'Failed to create patient.'], 500);
                    }
                    $patient = $patientModel->find($patientId);
                }
        
                $appointmentModel = new AppointmentModel();
        
                $existingAppointment = $appointmentModel->where('doctor_id', $doctor_id)
                    ->where('appointment_date', $date)
                    ->where('start_time', $time)
                    ->first();
        
                if ($existingAppointment) {
                    return $this->response->setJSON(['message' => 'Appointment already exists at this time.'], 400);
                }
        
                $meetLink = null;
        
                $data = [
                    'doctor_id'         => $doctor_id,
                    'appointment_date'  => $date,
                    'start_time'        => $time,
                    'status'            => 'Scheduled',
                    'patient_id'        => $patient['id'],
                    'appointment_type'  => $appointment_type,
                    'google_meet_link'  => $meetLink
                ];
        
                if (!$appointmentModel->insert($data)) {
                    log_message('error', 'Failed to insert appointment record');
                    return $this->response->setJSON(['error' => 'Failed to book appointment.'], 500);
                }
        
                // Send confirmation email if patient has email
                if (!empty($patient['email'])) {
                    $this->sendAppointmentEmail($patient['email'], $date, $time, $appointment_type, $meetLink);
                }
        
                return $this->response->setJSON(['message' => 'Appointment booked successfully!']);
        
            } catch (\Exception $e) {
                log_message('error', 'Error booking appointment: ' . $e->getMessage());
                return $this->response->setJSON(['error' => 'Internal server error.'], 500);
            }
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