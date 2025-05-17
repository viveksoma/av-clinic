<?php
namespace App\Models\Admin;

use CodeIgniter\Model;

class PatientTimelineModel extends Model
{
    protected $table      = 'patient_timeline';
    protected $primaryKey = 'id';
    protected $allowedFields = ['patient_id','title','text', 'file', 'doctor_id', 'created_at'];
}
?>