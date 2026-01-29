<?php
namespace App\Models;

use CodeIgniter\Model;

class DoctorModel extends Model
{
    protected $table = 'doctors'; // Database table name
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'specialization',
        'slot_duration',
        'qualifications',
        'about',
        'social_links',
        'profile_pic',
        'email',
        'supports_online_consultation'
    ]; // Editable fields
    // Enable timestamps (created_at, updated_at)
    protected $useTimestamps = true;
    
    // Set custom date format for created_at, updated_at
    protected $dateFormat = 'datetime';
}

?>