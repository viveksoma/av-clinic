<?php
namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patients'; // Database table name
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'age', 'phone']; // Editable fields
    // Enable timestamps (created_at, updated_at)
    protected $useTimestamps = true;
    
    // Set custom date format for created_at, updated_at
    protected $dateFormat = 'datetime';
}

?>