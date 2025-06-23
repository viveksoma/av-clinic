<?php

use Config\Services;

if (!function_exists('sendAppointmentEmail')) {
    /**
     * Send appointment confirmation email.
     *
     * @param string $toEmail
     * @param string $date
     * @param string $time
     * @param string $type
     * @param ?string $meetLink
     * @return bool
     */
    function sendAppointmentEmail(string $toEmail, string $date, string $time, string $type, ?string $meetLink = null): bool
    {
        $email = Services::email();
        $email->setMailType('html'); // ✅ Ensure HTML
    
        $email->setFrom('no-reply@avclinic.com', 'AV Clinic');
        $email->setTo($toEmail);
        $email->setSubject('Appointment Confirmation');
    
        $message = "Dear Patient,<br><br>";
        $message .= "Your appointment is scheduled on <strong>$date</strong> at <strong>$time</strong>.<br>";
    
        if ($type === 'online' && $meetLink) {
            $message .= "Please join your online consultation via Google Meet:<br>";
            $message .= "<a href=\"$meetLink\">$meetLink</a><br><br>";
        }
    
        $message .= "Thank you,<br>Clinic Team";
    
        $email->setMessage($message);
    
        return $email->send();
    }    
    
}
