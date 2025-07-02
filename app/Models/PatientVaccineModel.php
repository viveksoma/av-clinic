<?php
namespace App\Models;

use CodeIgniter\Model;

class PatientVaccineModel extends Model
{
    protected $table = 'patient_vaccines';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'patient_id',
        'vaccine_name',
        'dose_number',
        'vaccination_date',
        'created_at',
    ];
}
