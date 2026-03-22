<?php

// app/Controllers/StudentInfo.php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StudentInfoModel;
use App\Models\RoleModel;

/**
 * StudentInfo
 *
 * Handles creation of new student records (account + academic info).
 * Accessible by: teacher and admin roles.
 *
 * Routes:
 *   GET  /students/create  → create()  Show the create form
 *   POST /students/store   → store()   Validate and persist
 */
class StudentInfo extends BaseController
{
    protected UserModel $userModel;
    protected StudentInfoModel $studentInfoModel;
    protected RoleModel $roleModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->userModel        = new UserModel();
        $this->studentInfoModel = new StudentInfoModel();
        $this->roleModel        = new RoleModel();
    }

    // ── CREATE FORM ───────────────────────────────────────────
    public function create()
    {
        return view('teacher/student_create');
    }

    // ── STORE ─────────────────────────────────────────────────
    public function store()
    {
        $rules = [
            'name'               => 'required|min_length[2]|max_length[100]',
            'email'              => 'required|valid_email|is_unique[users.email]',
            'password'           => 'required|min_length[8]',
            'confirm_password'   => 'required|matches[password]',
            'student_display_id' => 'permit_empty|max_length[20]',
            'course'             => 'permit_empty|max_length[100]',
            'year_level'         => 'permit_empty|integer|in_list[1,2,3,4,5,6]',
            'section'            => 'permit_empty|max_length[50]',
            'phone'              => 'permit_empty|max_length[20]',
            'address'            => 'permit_empty|max_length[500]',
        ];

        $messages = [
            'confirm_password' => [
                'matches' => 'Passwords do not match.',
            ],
            'email' => [
                'is_unique' => 'That email is already registered.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        // Resolve the student role ID
        $studentRole = $this->roleModel->findByName('student');

        if (! $studentRole) {
            session()->setFlashdata('error', 'Student role is not configured. Please set it up under Role Management first.');
            return redirect()->back()->withInput();
        }

        $db = $this->userModel->db;
        $db->transStart();

        // 1. Create user account
        $userId = $this->userModel->skipValidation(true)->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_id'  => $studentRole['id'],
        ]);

        // 2. Create linked student record
        if ($userId) {
            $this->studentInfoModel->skipValidation(true)->insert([
                'student_id'         => $userId,
                'student_display_id' => $this->request->getPost('student_display_id') ?: null,
                'course'             => $this->request->getPost('course') ?: null,
                'year_level'         => $this->request->getPost('year_level') ?: null,
                'section'            => $this->request->getPost('section') ?: null,
                'phone'              => $this->request->getPost('phone') ?: null,
                'address'            => $this->request->getPost('address') ?: null,
            ]);
        }

        $db->transComplete();

        if (! $db->transStatus()) {
            session()->setFlashdata('error', 'Failed to create student. Please try again.');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success', 'Student "' . esc($this->request->getPost('name')) . '" has been created successfully.');
        return redirect()->to('/students');
    }
}
