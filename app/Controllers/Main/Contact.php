<?php

namespace App\Controllers\Main;

use App\Controllers\BaseController;

class Contact extends BaseController
{
    public function index(): string
    {
        $data = array();
        return view('main/contact', $data);  // Correct method to load view in CI4
    }
}
