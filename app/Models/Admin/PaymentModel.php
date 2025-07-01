<?php
namespace App\Models\Admin;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'appointment_id',
        'payment_amount',
        'payment_mode',
        'payment_status',
    ];
    protected $useTimestamps = true;
}
