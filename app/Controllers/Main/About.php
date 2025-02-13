<?php

namespace App\Controllers\Main;

use App\Controllers\BaseController;

class About extends BaseController
{
    public function index(): string
    {
        $data = array();
        return view('main/about', $data);  // Correct method to load view in CI4
    }
}
