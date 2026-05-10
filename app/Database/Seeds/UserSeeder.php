<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'admin',
                'email'      => 'admin@example.com',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'first_name' => 'System',
                'last_name'  => 'Admin',
                'role'       => 'Admin',
                'status'     => 'Active',
            ],
            [
                'username'   => 'staff',
                'email'      => 'staff@example.com',
                'password'   => password_hash('staff123', PASSWORD_BCRYPT),
                'first_name' => 'Store',
                'last_name'  => 'Staff',
                'role'       => 'Staff',
                'status'     => 'Active',
            ],
            [
                'username'   => 'customer',
                'email'      => 'customer@example.com',
                'password'   => password_hash('customer123', PASSWORD_BCRYPT),
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'role'       => 'Customer',
                'status'     => 'Active',
            ],
            [
                'username'   => 'customer2',
                'email'      => 'customer2@example.com',
                'password'   => password_hash('customer123', PASSWORD_BCRYPT),
                'first_name' => 'Jane',
                'last_name'  => 'Smith',
                'role'       => 'Customer',
                'status'     => 'Active',
            ],
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}