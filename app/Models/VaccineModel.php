<?php

namespace App\Models;

use CodeIgniter\Model;

class VaccineModel extends Model
{
    protected $table = 'vaccines';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'due_weeks', 'description'];
    protected $useTimestamps = true;
}
