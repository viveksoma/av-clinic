<?php

namespace App\Controllers\Admin;
use App\Models\Admin\UserModel;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login()
    {
        helper(['form', 'url']);
        return view('admin/login');
    }

    public function loginSubmit()
    {
        $session = session();
        $userModel = new UserModel();
        $request = service('request');

        // Form Validation Rules
        $rules = [
            'username'    => 'required',
            'password' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return view('admin/login', ['validation' => $this->validator]);
        }

        // Fetch User
        $username = $request->getPost('username');
        $password = $request->getPost('password');
        $remember = $request->getPost('remember');

        $user = $userModel->getUserByUserName($username);

        if ($user && password_verify($password, $user['password'])) {
            $session->set(['user_id' => $user['id'], 'username' => $user['username'], 'logged_in' => true]);
            if ($remember) {
                $cookieData = json_encode(['username' => $username, 'password' => $password]);
                setcookie("remember_me", base64_encode($cookieData), time() + (86400 * 30), "/"); // 30 Days
            }
            return redirect()->to('admin/dashboard');
        } else {
            return view('admin/login', ['error' => 'Invalid User Name or Password']);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}


