<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DoctorModel;
use App\Models\AppointmentModel;
use App\Libraries\GoogleMeetService;

class Appointments extends BaseController
{
    public function index(): string
    {
        $data = [];
        $doctorModel = new DoctorModel();
        $appointmentModel = new AppointmentModel();
        $data['doctors'] = $doctorModel->findAll();

        // Get filter values
        $fromOnline = $this->request->getGet('from_date_online');
        $toOnline = $this->request->getGet('to_date_online');
        $fromOther = $this->request->getGet('from_date_other');
        $toOther = $this->request->getGet('to_date_other');

        $today = date('Y-m-d');

        // ONLINE APPOINTMENTS
        $onlineQuery = $appointmentModel
            ->select('
                    appointments.*, 
                    patients.name as patient_name, 
                    doctors.name as doctor_name, 
                    payments.payment_status, 
                    payments.payment_amount, 
                    payments.payment_mode
                ')
            ->join('payments', 'payments.appointment_id = appointments.id', 'left')
            ->join('patients', 'patients.id = appointments.patient_id')
            ->join('doctors', 'doctors.id = appointments.doctor_id')
            ->where('appointment_type', 'online');

        if ($fromOnline || $toOnline) {
            if ($fromOnline) {
                $onlineQuery->where('appointment_date >=', $fromOnline);
            }
            if ($toOnline) {
                $onlineQuery->where('appointment_date <=', $toOnline);
            }
        } else {
            // Default to today and future
            $onlineQuery->where('appointment_date >=', $today);
        }

        $data['onlineAppointments'] = $onlineQuery
            ->orderBy('appointment_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->findAll();

        // OTHER APPOINTMENTS
        $otherQuery = $appointmentModel
            ->select('appointments.*, patients.name as patient_name, doctors.name as doctor_name')
            ->join('patients', 'patients.id = appointments.patient_id')
            ->join('doctors', 'doctors.id = appointments.doctor_id')
            ->where('appointment_type !=', 'online');

        if ($fromOther || $toOther) {
            if ($fromOther) {
                $otherQuery->where('appointment_date >=', $fromOther);
            }
            if ($toOther) {
                $otherQuery->where('appointment_date <=', $toOther);
            }
        } else {
            // Default to today and future
            $otherQuery->where('appointment_date >=', $today);
        }

        $data['otherAppointments'] = $otherQuery
            ->orderBy('appointment_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->findAll();

        // Pass filters back to view
        $data['fromOnline'] = $fromOnline;
        $data['toOnline'] = $toOnline;
        $data['fromOther'] = $fromOther;
        $data['toOther'] = $toOther;

        return view('admin/appointments', $data);
    }

    public function generateMeet($appointmentId)
    {
        helper('email');
        $appointmentModel = new \App\Models\AppointmentModel();
        $appointment = $appointmentModel
            ->select('appointments.*, patients.name as patient_name, patients.email as patient_email, doctors.email as doctor_email, doctors.name as doctor_name')
            ->join('patients', 'patients.id = appointments.patient_id')
            ->join('doctors', 'doctors.id = appointments.doctor_id')
            ->find($appointmentId);
        if (!$appointment || $appointment['appointment_type'] !== 'online') {
            return redirect()->back()->with('error', 'Invalid or non-online appointment.');
        }

        $startTime = date('c', strtotime($appointment['appointment_date'] . ' ' . $appointment['start_time']));
        $endTime = date('c', strtotime("+15 minutes", strtotime($startTime)));

        $appointmentDate = $appointment['appointment_date'];
        $appointmentTime = $appointment['start_time'];

        $attendees = ['appointment@avmultispeciality.com', $appointment['patient_email']];

        $meetService = new GoogleMeetService();
        $link = $meetService->createMeetLink(
            "Consultation with " . $appointment['doctor_name'],
            $appointmentDate,
            $appointmentTime,
            15,
            $attendees
        );

        $appointmentModel->update($appointmentId, ['google_meet_link' => $link['meet_link']]);

        sendGoogleMeetEmail(
            $appointment['patient_email'],
            $appointment['patient_name'],
            $appointment['doctor_name'],
            $appointment['appointment_date'],
            $appointment['start_time'],
            $link['meet_link']
        );

        return view('admin/appointments', $data);
    }



}
