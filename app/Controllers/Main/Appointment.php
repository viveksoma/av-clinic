<?php

namespace App\Controllers\Main;

use App\Controllers\BaseController;

class Appointment extends BaseController
{
    public function index(): string
    {
        $data = array();
        return view('main/appointment', $data);  // Correct method to load view in CI4
    }
}
