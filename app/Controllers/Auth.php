<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $userModel;
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        if ($this->request->is('post')) {
            $validation = \Config\Services::validation();

            $rules = [
                'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]',
                'first_name' => 'required|min_length[2]',
                'last_name' => 'required|min_length[2]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $hashedPassword,
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'role' => 'Customer',
                'status' => 'Active',
            ];

            if ($this->userModel->insert($data)) {
                session()->setFlashdata('success', 'Registration successful! Please login.');
                return redirect()->to('/auth/login');
            } else {
                session()->setFlashdata('error', 'Registration failed. Please try again.');
                return redirect()->back()->withInput();
            }
        }

        return view('auth/register');
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $this->userModel->where('username', $username)
                                     ->orWhere('email', $username)
                                     ->first();

            if (!$user) {
                session()->setFlashdata('error', 'Invalid username/email or password.');
                return redirect()->back();
            }

            if ($user['status'] !== 'Active') {
                session()->setFlashdata('error', 'Your account is not active.');
                return redirect()->back();
            }

            if (!password_verify($password, $user['password'])) {
                session()->setFlashdata('error', 'Invalid username/email or password.');
                return redirect()->back();
            }

            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'logged_in' => true,
            ]);

            session()->setFlashdata('success', 'Login successful! Welcome ' . $user['first_name']);
            
            if ($user['role'] === 'Admin' || $user['role'] === 'Staff') {
                return redirect()->to('/dashboard');
            }
            
            return redirect()->to('/');
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to('/auth/login');
    }

    public function profile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $user = $this->userModel->find(session()->get('user_id'));
        return view('auth/profile', ['user' => $user]);
    }

    public function updateProfile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        if ($this->request->is('post')) {
            $rules = [
                'first_name' => 'required|min_length[2]',
                'last_name' => 'required|min_length[2]',
                'phone' => 'permit_empty|string',
                'address' => 'permit_empty|string',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userId = session()->get('user_id');
            $data = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
            ];

            if ($this->userModel->update($userId, $data)) {
                session()->set('first_name', $data['first_name']);
                session()->set('last_name', $data['last_name']);
                session()->setFlashdata('success', 'Profile updated successfully!');
                return redirect()->to('/auth/profile');
            } else {
                session()->setFlashdata('error', 'Failed to update profile.');
                return redirect()->back()->withInput();
            }
        }

        return redirect()->back();
    }

    public function changePassword()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        if ($this->request->is('post')) {
            $rules = [
                'current_password' => 'required',
                'new_password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[new_password]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->with('errors', $this->validator->getErrors());
            }

            $user = $this->userModel->find(session()->get('user_id'));

            if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
                session()->setFlashdata('error', 'Current password is incorrect.');
                return redirect()->back();
            }

            $hashedPassword = password_hash($this->request->getPost('new_password'), PASSWORD_BCRYPT);
            
            if ($this->userModel->update($user['id'], ['password' => $hashedPassword])) {
                session()->setFlashdata('success', 'Password changed successfully!');
                return redirect()->to('/auth/profile');
            } else {
                session()->setFlashdata('error', 'Failed to change password.');
                return redirect()->back();
            }
        }

        return view('auth/change-password');
    }
}
