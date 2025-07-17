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
    function sendAppointmentEmail(string $toEmail, string $date, string $time, string $type): bool
    {
        $email = Services::email();
        $email->setMailType('html');

        $email->setFrom('no-reply@avclinic.com', 'AV Clinic');
        $email->setTo($toEmail);
        $email->setSubject('Appointment Confirmation');

        $message = "Dear Patient,<br><br>";
        $message .= "Your appointment is scheduled on <strong>$date</strong> at <strong>$time</strong>.<br><br>";

        if ($type === 'online') {
            $message .= "To confirm your online consultation, please make the payment using the following details:<br><br>";
            $message .= "Pay via UPI:<br>";
            $message .= "<strong>UPI ID:</strong> vidhuvarsha7-5@okicici<br><br>";
            $message .= "<img src='" . base_url('assets/main/img/QRCode.png') . "' alt='UPI QR Code' width='200'><br><br>";
            $message .= "After payment, please send the screenshot to WhatsApp: <strong>9486721349</strong><br>";
            $message .= "We will then send you the Google Meet link for the consultation.<br><br>";
        }

        $message .= "Thank you,<br>Clinic Team";

        $email->setMessage($message);

        return $email->send();
    }
}

function sendGoogleMeetEmail(string $toEmail, string $patientName, string $doctorName, string $appointmentDate, string $appointmentTime, string $meetLink): bool
{
    $email = \Config\Services::email();
    $email->setMailType('html');

    $email->setFrom('no-reply@avclinic.com', 'AV Clinic');
    $email->setTo($toEmail);
    $email->setSubject('Your Google Meet Link for Online Consultation');

    $formattedDate = date('d M Y', strtotime($appointmentDate));
    $formattedTime = date('h:i A', strtotime($appointmentTime));

    $message = "
        Dear {$patientName},<br><br>
        Your online consultation with <strong>Dr. {$doctorName}</strong> is confirmed.<br><br>
        <strong>Date:</strong> {$formattedDate}<br>
        <strong>Time:</strong> {$formattedTime}<br><br>
        <strong>Join the Meeting:</strong><br>
        <a href=\"{$meetLink}\" target=\"_blank\">{$meetLink}</a><br><br>
        Please make sure to join the meeting on time. <br>
        If you face any issues, feel free to contact us on <strong>+91-9486721349</strong>.<br><br>
        Regards,<br>
        <strong>AV Clinic</strong>
    ";

    $email->setMessage($message);

    return $email->send();
}

if (!function_exists('sendVaccineReminderEmail')) {
    /**
     * Send vaccine reminder email to a patient.
     *
     * @param string $toEmail
     * @param string $patientName
     * @param string $vaccineName
     * @param string $doseNumber
     * @param string $scheduledDate (Y-m-d)
     * @return bool
     */
    function sendVaccineReminderEmail(string $toEmail, string $patientName, string $vaccineName, string $doseNumber, string $scheduledDate): bool
    {
        $email = \Config\Services::email();
        $email->setMailType('html');

        $email->setFrom('no-reply@avclinic.com', 'AV Clinic');
        $email->setTo($toEmail);
        $email->setSubject('Upcoming Vaccine Reminder');

        $formattedDate = date('d M Y', strtotime($scheduledDate));

        $message = "
            Dear {$patientName},<br><br>
            This is a reminder for your upcoming vaccination.<br><br>
            <strong>Vaccine:</strong> {$vaccineName}<br>
            <strong>Dose:</strong> {$doseNumber}<br>
            <strong>Scheduled Date:</strong> {$formattedDate}<br><br>
            Please visit <strong>AV Clinic</strong> on or before the scheduled date.<br><br>
            Thank you,<br>
            <strong>AV Clinic Team</strong>
        ";

        $email->setMessage($message);

        return $email->send();
    }
}
