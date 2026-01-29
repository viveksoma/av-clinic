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

        $email->setFrom('no-reply@avmultispeciality.com', 'AV Clinic');
        $email->setTo($toEmail);
        $email->setSubject('Appointment Confirmation');

        $message  = "Dear Patient,<br><br>";
        $message .= "Your appointment is scheduled on <strong>$date</strong> at <strong>$time</strong>.<br><br>";

        if ($type === 'online') {

            $qrUrl  = generateUpiQr($amount, 'Online Consultation');
            $upiUrl = generateUpiUrl($amount);
            $upiId = 'vidhuvarsha7-5@okicici'; // YOUR UPI ID

            $message .= "To confirm your online consultation, please make the payment.<br><br>";
            $message .= "<strong>Amount:</strong> ₹{$amount}<br>";
            $message .= "<strong>UPI ID:</strong> {$upiId}<br>
            <small>(You can copy–paste this UPI ID into any UPI app)</small><br><br>

            <a href='https://paytm.com'
            style='display:inline-block;padding:12px 18px;
                    background:#28a745;color:#fff;
                    text-decoration:none;border-radius:5px;'>
            Open UPI App & Pay ₹{$amount}
            </a><br><br>

            <small>
            📱 On mobile: scanning the QR below will open your UPI app automatically with the amount filled.
            </small><br><br>
            ";
            $message .= "<img src='{$qrUrl}' alt='UPI QR Code' width='220'><br><br>";
            $message .= "Scan the QR code — the amount will be filled automatically.<br><br>";
            $message .= "After payment, send the screenshot to WhatsApp: <strong>90420768040</strong><br><br>";
        }

        $message .= "Thank you,<br>AV Clinic";

        $email->setMessage($message);

        return $email->send();

    }
}

function sendOnlineAppointmentNotification(
    string $patientName,
    string $patientPhone,
    string $doctorName,
    string $appointmentDate,
    string $appointmentTime,
    string $appointmentType
) {
    try {
        $email = \Config\Services::email();
        $email->setMailType('html');

        $email->setFrom('no-reply@avmultispeciality.com', 'AV Clinic');
        $email->setTo('appointment@avmultispeciality.com');
        $email->setSubject('New Online Appointment Request');

        $formattedDate = date('d M Y', strtotime($appointmentDate));
        $formattedTime = date('h:i A', strtotime($appointmentTime));

        $message = "
            Dear Team,<br><br>

            A <strong>new online appointment request</strong> has been received.<br><br>

            <strong>Patient Name:</strong> {$patientName}<br>
            <strong>Patient Phone:</strong> {$patientPhone}<br>
            <strong>Doctor:</strong> Dr. {$doctorName}<br>
            <strong>Appointment Type:</strong> {$appointmentType}<br>
            <strong>Date:</strong> {$formattedDate}<br>
            <strong>Time:</strong> {$formattedTime}<br><br>

            Please review and take the necessary action.<br><br>

            Regards,<br>
            <strong>AV Clinic System</strong>
        ";

        $email->setMessage($message);

        if (!$email->send()) {
            log_message('error', 'Admin online appointment mail failed: ' . print_r($email->printDebugger(), true));
        }

    } catch (\Throwable $e) {
        log_message('error', 'Admin online appointment mail exception: ' . $e->getMessage());
    }
}


function sendGoogleMeetEmail(string $toEmail, string $patientName, string $doctorName, string $appointmentDate, string $appointmentTime, string $meetLink): bool
{
    $email = \Config\Services::email();
    $email->setMailType('html');

    $email->setFrom('no-reply@avmultispeciality.com', 'AV Clinic');
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
        If you face any issues, feel free to contact us on <strong>+91-90420768040</strong>.<br><br>
        Regards,<br>
        <strong>AV Clinic</strong>
    ";

    $email->setMessage($message);

    return $email->send();
}

function sendGroupedVaccineReminderEmail(
    string $toEmail,
    string $patientName,
    array $vaccines,
    string $reminderType
): bool {

    $email = \Config\Services::email();
    $email->setMailType('html');

    $email->setFrom('no-reply@avmultispeciality.com', 'AV Clinic');
    $email->setTo($toEmail);

    $subjectMap = [
        '7_days'   => 'Upcoming Vaccines – 7 Days to Go',
        '3_days'   => 'Upcoming Vaccines – 3 Days to Go',
        'same_day' => 'Vaccines Due Today'
    ];

    $email->setSubject($subjectMap[$reminderType] ?? 'Vaccine Reminder');

    $message  = "Dear {$patientName},<br><br>";
    $message .= "The following vaccinations are scheduled for your child:<br><br>";

    $message .= "
        <table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;'>
            <tr>
                <th>Vaccine</th>
                <th>Dose</th>
                <th>Due Date</th>
            </tr>
    ";

    foreach ($vaccines as $v) {
        $message .= "
            <tr>
                <td>{$v['vaccine_name']}</td>
                <td>{$v['dose_label']}</td>
                <td>" . date('d M Y', strtotime($v['due_date'])) . "</td>
            </tr>
        ";
    }

    $message .= "</table><br>";

    $message .= "
        Please visit <strong>AV Clinic</strong> for vaccination.<br><br>
        Regards,<br>
        <strong>AV Clinic Team</strong>
    ";

    $email->setMessage($message);

    return $email->send();
}
