<?php

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if (!function_exists('generateUpiUrl')) {
    function generateUpiUrl(float $amount, string $note = 'Online Consultation'): string
    {
        $upiId = 'vidhuvarsha7-5@okicici'; // YOUR UPI ID
        $name  = urlencode('AV Clinic');
        $note  = urlencode($note);

        return "upi://pay?pa={$upiId}&pn={$name}&am={$amount}&cu=INR&tn={$note}";
    }
}

if (!function_exists('generateUpiQr')) {
    function generateUpiQr(float $amount, string $note = 'Online Consultation'): string
    {
        $upiUrl = generateUpiUrl($amount, $note);

        $qrCode = new QrCode($upiUrl);

        $writer = new PngWriter();

        // v6: size & margin go HERE
        $result = $writer->write(
            $qrCode,
            null,
            null,
            [
                'size'   => 300,
                'margin' => 10,
            ]
        );

        $dir = WRITEPATH . 'qrcodes/';
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $filename = 'upi_' . uniqid() . '.png';
        $path     = $dir . $filename;

        $result->saveToFile($path);

        return base_url('writable/qrcodes/' . $filename);
    }
}
