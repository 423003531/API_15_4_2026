<?php

// app/Filters/TeacherFilter.php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * TeacherFilter
 *
 * Gate 2 (Role) — Ensures the logged-in user has at least the 'teacher' role.
 *
 * Allowed roles: teacher, admin
 * (Admin can access teacher pages too — hierarchy matters.)
 *
 * Applied to routes:
 *  - /dashboard
 *  - /students  (student management list)
 *  - /students/show/{id}
 */
class TeacherFilter implements FilterInterface
{
    // Roles that are allowed through this filter
    protected array $allowedRoles = ['teacher', 'admin'];

    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session('user')['role'] ?? null;

        if (! in_array($role, $this->allowedRoles, true)) {
            session()->setFlashdata('error', 'Access denied. This area requires Teacher or Admin access.');
            return redirect()->to('/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
