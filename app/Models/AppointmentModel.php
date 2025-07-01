<?php
namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointments'; // Table name
    protected $primaryKey = 'id'; // Assuming 'id' is the primary key
    protected $allowedFields = ['doctor_id', 'appointment_date', 'start_time', 'status', 'patient_id', 'appointment_type', 'google_meet_link']; // Fields you want to allow for insertion
    protected $useTimestamps = true; // If you want timestamps (created_at/updated_at) to be handled automatically

    public function getAvailableSlots($doctor_id, $date)
    {
            // Get the day of the week from the selected date
        $dayOfWeek = date('l', strtotime($date)); // Converts date to day name (e.g., 'Monday', 'Tuesday')

        // Get availability for the selected day only
        $availability = $this->db->table('doctor_availabilities')
            ->where('doctor_id', $doctor_id)
            ->where('day_of_week', $dayOfWeek)
            ->get()->getResultArray();

        // If no availability, return default slots (morning 10-1, evening 3-8)
        if (empty($availability)) {
            return [
                'morning_slots' => $this->generateSlots('10:00', '13:00'),
                'evening_slots' => $this->generateSlots('15:00', '20:00')
            ];
        }

        // Generate available slots based on doctor availability
        $morning_slots = [];
        $evening_slots = [];
        foreach ($availability as $slot) {
            $morning_slots = array_merge($morning_slots, $this->generateSlots($slot['morning_start'], $slot['morning_end']));
            $evening_slots = array_merge($evening_slots, $this->generateSlots($slot['evening_start'], $slot['evening_end']));
        }

        // Check for booked appointments
        $booked_slots = $this->db->table('appointments')
            ->where('doctor_id', $doctor_id)
            ->where('appointment_date', $date)
            ->select("TIME_FORMAT(start_time, '%H:%i') as start_time") // Remove seconds
            ->get()->getResultArray();

        $booked_times = [];
        foreach ($booked_slots as $appointment) {
            $booked_times[] = $appointment['start_time'];
        }

         // Remove booked slots from available slots
         $morning_slots = array_diff($morning_slots, $booked_times);
         $evening_slots = array_diff($evening_slots, $booked_times);
 
         return [
            'morning_slots' => $morning_slots,
            'evening_slots' => $evening_slots
         ];
    }

    public function getBookedSlots($doctor_id, $date)
    {
        $bookedSlots = $this->db->table('appointments')
            ->select('start_time')
            ->where('doctor_id', $doctor_id)
            ->where('appointment_date', $date)
            ->select("TIME_FORMAT(start_time, '%H:%i') as start_time") // Remove seconds
            ->get()
            ->getResultArray();

        // Extract the start_times from the result to return a list of booked slots
        $bookedTimes = array_map(function($appointment) {
            return $appointment['start_time'];
        }, $bookedSlots);

        return $bookedTimes;
    }

    private function generateSlots($startTime, $endTime)
    {
        $slots = [];
        $start = strtotime($startTime);
        $end = strtotime($endTime);
        $interval = 15 * 60; // 15 minutes in seconds
    
        while ($start < $end) {
            $slots[] = date("H:i", $start);
            $start += $interval;
        }
    
        return $slots;
    }
}
?>