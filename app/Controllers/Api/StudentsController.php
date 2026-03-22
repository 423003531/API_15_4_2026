<?php

namespace App\Controllers\Api;

use App\Models\UserModel;

/**
 * API Students Controller
 *
 * GET  /api/v1/students        → paginated list of students
 * GET  /api/v1/students/{id}   → single student profile
 *
 * Requires: Bearer token (teacher or admin role)
 */
class StudentsController extends BaseApiController
{
    private UserModel $userModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
        $this->userModel = new UserModel();
    }

    // ── GET /api/v1/students ──────────────────────────────────────────────────

    public function index()
    {
        if (! $this->hasTeacherAccess()) {
            return $this->forbidden('Only teachers and admins can list students.');
        }

        $students = $this->userModel->getStudents();

        // Remove password hashes from output
        $students = array_map([$this, 'sanitize'], $students);

        return $this->ok($students);
    }

    // ── GET /api/v1/students/{id} ─────────────────────────────────────────────

    public function show(int $id)
    {
        if (! $this->hasTeacherAccess()) {
            return $this->forbidden('Only teachers and admins can view student profiles.');
        }

        $student = $this->userModel->getStudentById($id);

        if (! $student) {
            return $this->notFound("Student #{$id} not found.");
        }

        return $this->ok($this->sanitize($student));
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /** Allow teachers and admins; block students from the API list. */
    private function hasTeacherAccess(): bool
    {
        return $this->apiUser && in_array($this->apiUser['role_name'], ['teacher', 'admin'], true);
    }

    /** Strip sensitive fields before sending to client. */
    private function sanitize(array $row): array
    {
        unset($row['password'], $row['deleted_at']);
        return $row;
    }
}
