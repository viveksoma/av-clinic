<?php

use Config\Services;
helper('upi');

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
    function sendAppointmentEmail(
        string $toEmail,
        string $date,
        string $time,
        string $type,
        float $amount = 300 
    ): bool {
        $email = Services::email();
        $email->setMailType('html');

        $email->setFrom('no-reply@avclinic.com', 'AV Clinic');
        $email->setTo($toEmail);
        $email->setSubject('Appointment Confirmation');

        $message  = "Dear Patient,<br><br>";
        $message .= "Your appointment is scheduled on <strong>$date</strong> at <strong>$time</strong>.<br><br>";

        if ($type === 'online') {

            $qrUrl  = generateUpiQr($amount, 'Online Consultation');
            $upiUrl = generateUpiUrl($amount);

            $message .= "To confirm your online consultation, please make the payment.<br><br>";
            $message .= "<strong>Amount:</strong> ₹{$amount}<br>";
            $message .= "<a href='{$upiUrl}' 
                style='display:inline-block;padding:12px 18px;
                    background:#28a745;color:#fff;
                    text-decoration:none;border-radius:5px;'>
                Pay ₹'{$amount}' via UPI
            </a><br><br>";
            $message .= "<img src='{$qrUrl}' alt='UPI QR Code' width='220'><br><br>";
            $message .= "Scan the QR code — the amount will be filled automatically.<br><br>";
            $message .= "After payment, send the screenshot to WhatsApp: <strong>90420768040</strong><br><br>";
        }

        $message .= "Thank you,<br>AV Clinic";

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

function sendVaccineReminderEmail(
    string $toEmail,
    string $patientName,
    string $vaccineName,
    string $doseLabel,
    string $scheduledDate,
    string $reminderType
): bool {
    $email = \Config\Services::email();
    $email->setMailType('html');

    $email->setFrom('no-reply@avclinic.com', 'AV Clinic');
    $email->setTo($toEmail);

    $subjectMap = [
        '7_days'   => 'Vaccine Reminder – 7 Days to Go',
        '3_days'   => 'Vaccine Reminder – 3 Days to Go',
        'same_day' => 'Vaccine Due Today'
    ];

    $email->setSubject($subjectMap[$reminderType] ?? 'Vaccine Reminder');

    $formattedDate = date('d M Y', strtotime($scheduledDate));

    $message = "
        Dear {$patientName},<br><br>
        This is a reminder for your child's vaccination.<br><br>
        <strong>Vaccine:</strong> {$vaccineName}<br>
        <strong>Dose:</strong> {$doseLabel}<br>
        <strong>Due Date:</strong> {$formattedDate}<br><br>
        Please visit <strong>AV Clinic</strong>.<br><br>
        Regards,<br>
        <strong>AV Clinic Team</strong>
    ";

    $email->setMessage($message);
    return $email->send();
}
