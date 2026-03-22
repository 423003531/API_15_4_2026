<?php

// app/Models/UserModel.php  (UPDATED for RBAC Activity)

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';
    protected $deletedField   = 'deleted_at';

    protected $allowedFields = [
        'name', 'email', 'password',
        'role_id',          // ← new: foreign key to roles table
        'student_id', 'student_display_id', 'course', 'year_level', 'section',
        'phone', 'address', 'profile_image',
    ];

    protected $returnType = 'array';

    // ── Validation (registration only) ───────────────────────
    protected $validationRules = [
        'name'     => 'required|min_length[2]|max_length[100]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
    ];

    // ── Custom methods ────────────────────────────────────────

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Return a user with their role name joined in.
     * Uses a raw query join so we get role.name alongside user data.
     *
     * @param int $id  User ID
     */
    public function findWithRole(int $id): ?array
    {
        return $this->db->table('users u')
            ->select('u.*, r.name AS role_name, r.label AS role_label')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->where('u.id', $id)
            ->where('u.deleted_at IS NULL')
            ->get()
            ->getRowArray();
    }

    /**
     * Return all users with their role label joined in.
     * Used by the Teacher/Admin student management page.
     */
    public function getAllWithRoles(): array
    {
        return $this->db->table('users u')
            ->select('u.id, u.name, u.email, u.created_at,
                      r.name AS role_name, r.label AS role_label,
                      s.course, s.year_level, s.section, s.student_id,
                      s.phone, s.address, s.profile_image, s.student_display_id')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('students s', 's.student_id = u.id', 'left')
            ->where('u.deleted_at IS NULL')
            ->orderBy('u.name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function updateProfile(int $userId, array $data): bool
    {
        return $this->update($userId, $data);
    }

    /**
     * Return all users with the 'student' role, joined with student details.
     */
    public function getStudents(): array
    {
        return $this->db->table('users u')
            ->select('u.id, u.name, u.email, u.created_at,
                      r.name AS role_name, r.label AS role_label,
                      s.course, s.year_level, s.section, s.student_id,
                      s.phone, s.address, s.profile_image, s.student_display_id')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('students s', 's.student_id = u.id', 'left')
            ->where('u.deleted_at IS NULL')
            ->where('r.name', 'student')
            ->orderBy('u.name', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Return a single student's full profile (users + roles + students).
     * Returns null if not found or not a student.
     */
    public function getStudentById(int $id): ?array
    {
        return $this->db->table('users u')
            ->select('u.id, u.name, u.email, u.created_at,
                      r.name AS role_name, r.label AS role_label,
                      s.course, s.year_level, s.section, s.student_id,
                      s.phone, s.address, s.profile_image, s.student_display_id')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('students s', 's.student_id = u.id', 'left')
            ->where('u.id', $id)
            ->where('u.deleted_at IS NULL')
            ->get()
            ->getRowArray() ?: null;
    }

    /**
     * Set role_id to NULL for all users assigned to a given role.
     * Called before deleting a role to avoid FK violations.
     */
    public function unassignRole(int $roleId): void
    {
        $this->db->table('users')
            ->where('role_id', $roleId)
            ->update(['role_id' => null]);
    }
}
