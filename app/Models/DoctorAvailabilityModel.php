<?php
namespace App\Models;
use CodeIgniter\Model;

class DoctorAvailabilityModel extends Model
{
    protected $table = 'doctor_availabilities';
    protected $primaryKey = 'id';
    protected $allowedFields = ['doctor_id', 'day_of_week', 'morning_start', 'morning_end', 'evening_start', 'evening_end'];
}
