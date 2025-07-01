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
            $message .= "<strong>Bank Name:</strong> ABC Bank<br>";
            $message .= "<strong>Account Number:</strong> 1234567890<br>";
            $message .= "<strong>IFSC Code:</strong> ABCD0123456<br>";
            $message .= "<strong>Account Holder:</strong> AV Clinic<br><br>";
            $message .= "Or pay via UPI:<br>";
            $message .= "<strong>UPI ID:</strong> avclinic@upi<br><br>";
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
