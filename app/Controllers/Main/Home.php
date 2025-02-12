<?php

namespace App\Controllers\Main;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index(): string
    {
        $data = array();
        return view('main/home', $data);  // Correct method to load view in CI4
    }
}
