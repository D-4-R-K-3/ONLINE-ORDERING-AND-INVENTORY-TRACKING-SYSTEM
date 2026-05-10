<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            session()->setFlashdata('warning', 'Please login first.');
            return redirect()->to('/auth/login');
        }

        if (!$arguments) {
            return;
        }

        $userRole = session()->get('role');
        $allowedRoles = explode(',', $arguments[0]);
        $allowedRoles = array_map('trim', $allowedRoles);

        if (!in_array($userRole, $allowedRoles)) {
            session()->setFlashdata('error', 'You do not have permission to access this page.');
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
