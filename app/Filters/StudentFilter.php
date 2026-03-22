<?php

// app/Filters/StudentFilter.php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * StudentFilter
 *
 * Gate 2 (Role) — Ensures the logged-in user has the 'student' role.
 *
 * Allowed roles: student ONLY
 *
 * How it works:
 *  - AuthFilter already confirmed a session exists.
 *  - This filter reads session('user')['role'] which was set during login.
 *  - If the role is not 'student', redirect to an "Unauthorized" page.
 *
 * Applied to routes:
 *  - /student/dashboard
 *  - /profile
 *  - /profile/edit
 *  - /profile/update
 */
class StudentFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session('user')['role'] ?? null;

        // Allow student only
        if ($role !== 'student') {
            session()->setFlashdata('error', 'Access denied. This page is for Students only.');
            return redirect()->to('/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
