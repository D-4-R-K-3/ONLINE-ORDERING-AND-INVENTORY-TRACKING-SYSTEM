<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['username', 'email', 'password', 'first_name', 'last_name', 'phone', 'address', 'role', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'first_name' => 'required|min_length[2]|max_length[50]',
        'last_name' => 'required|min_length[2]|max_length[50]',
        'role' => 'required|in_list[Admin,Staff,Customer]',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getActiveUsers()
    {
        return $this->where('status', 'Active')->findAll();
    }

    public function getUsersByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }
}
