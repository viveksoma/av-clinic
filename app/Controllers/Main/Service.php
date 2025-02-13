<?php

namespace App\Controllers\Main;

use App\Controllers\BaseController;

class Service extends BaseController
{
    public function index(): string
    {
        $data = array();
        return view('main/service', $data);  // Correct method to load view in CI4
    }
}
