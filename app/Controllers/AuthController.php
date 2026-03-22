<?php

// app/Controllers/AuthController.php  (UPDATED for RBAC)

namespace App\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->has('user')) {
            return $this->redirectByRole(session('user')['role']);
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        $userModel = new UserModel();

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $found = $userModel->findByEmailWithRole($this->request->getPost('email'));

        if (! $found || ! password_verify($this->request->getPost('password'), $found['password'])) {
            return redirect()->back()->withInput()
                             ->with('error', 'Invalid email or password.');
        }

        // ── Store role in session so filters can read it ──────
        session()->set([
            'user' => [
                'id'    => $found['id'],
                'name'  => $found['name'],
                'email' => $found['email'],
                'role'  => $found['role_name'] ?? 'student',  // ← key for filters
            ],
        ]);

        session()->setFlashdata('success', 'Welcome, ' . $found['name'] . '!');
        return $this->redirectByRole($found['role_name'] ?? 'student');
    }

    /**
     * Redirect user to the correct dashboard based on their role.
     */
    protected function redirectByRole(?string $role): \CodeIgniter\HTTP\RedirectResponse
    {
        return match ($role) {
            'admin'   => redirect()->to('/dashboard'),
            'teacher' => redirect()->to('/dashboard'),
            'student' => redirect()->to('/student/dashboard'),
            default   => redirect()->to('/login'),
        };
    }

    public function register()
    {
        if (session()->has('user')) {
            return $this->redirectByRole(session('user')['role']);
        }
        return view('auth/register');
    }

    public function registerProcess()
    {
        $userModel = new UserModel();

        $rules = [
            'name'             => 'required|min_length[2]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (! $this->validate($rules, ['confirm_password' => ['matches' => 'Passwords do not match.']])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        // Get the student role ID (new registrations default to student)
        $studentRole = (new RoleModel())->findByName('student');

        $userModel->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role_id'  => $studentRole['id'] ?? null,
        ]);

        session()->setFlashdata('success', 'Registration successful! Please log in.');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Logged out successfully.');
        return redirect()->to('/login');
    }

    /**
     * 403 Unauthorized page — shown when a role filter blocks access.
     */
    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
}
