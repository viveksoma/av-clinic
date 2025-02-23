<?php
public function getAvailableSlots($doctor_id, $date)
{
    // Get the day of the week from the selected date
    $dayOfWeek = date('l', strtotime($date)); // Converts date to day name (e.g., 'Monday', 'Tuesday')

    // Get availability for the selected day only
    $availability = $this->db->table('doctor_availabilities')
        ->where('doctor_id', $doctor_id)
        ->where('day_of_week', $dayOfWeek)
        ->get()->getResultArray();

    // Log for debugging
    log_message('debug', "Doctor ID: $doctor_id, Date: $date, Day: $dayOfWeek");
    log_message('debug', "Availability: " . json_encode($availability));

    // If no availability found, return a default range
    if (empty($availability)) {
        return $this->generateDefaultSlots();
    }

    $slots = [];
    foreach ($availability as $slot) {
        $slots = array_merge($slots, $this->generateSlots($slot['morning_start'], $slot['morning_end']));
        $slots = array_merge($slots, $this->generateSlots($slot['evening_start'], $slot['evening_end']));
    }

    // Log the final slots being returned
    log_message('debug', "Generated Slots: " . json_encode($slots));

    return $slots;
}

private function generateDefaultSlots()
{
    // If no slots found for the selected doctor, return default slots (morning 9-1, evening 3-8)
    return array_merge(
        $this->generateSlots("09:00", "13:00"), // Morning
        $this->generateSlots("15:00", "20:00")  // Evening
    );
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


?>