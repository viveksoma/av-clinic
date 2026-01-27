<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password'];
    // Enable timestamps (created_at, updated_at)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // Set custom date format for created_at, updated_at
    protected $dateFormat = 'datetime';
    
    public function getUserByUserName($username)
    {
//         $hashedPassword = password_hash('12345', PASSWORD_DEFAULT);

// // Prepare and execute the SQL query

//         $hashedPassword = password_hash('12345', PASSWORD_DEFAULT);

//         return $this->insert([
//             'username' => 'admin',
//             'email' => 'viewvivek93@gmail.com',
//             'password' => $hashedPassword
//         ]);
        return $this->where('username', $username)->first();
    }
}
