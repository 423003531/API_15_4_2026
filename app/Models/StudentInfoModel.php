<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentInfoModel extends Model
{
    protected $table            = 'students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name',
        'email',
        'password',
        'student_id',
        'student_display_id',
        'course',
        'year_level',
        'section',
        'phone',
        'address',
        'profile_image',     // stores filename only, e.g. "avatar_3.jpg"
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
     // ── Validation rules for registration (unchanged) ────────────
    protected $validationRules = [
        'name'     => 'required|min_length[2]|max_length[100]',
        'email'    => 'required|valid_email|max_length[150]|is_unique[users.email]',
        'password' => 'required|min_length[8]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Find a user by email.
     */
    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    public function getAllWithRoles(int $userId): ?array
    {
        return $this->db->table('users u')
            ->select('u.id, u.name, u.email, u.created_at,
                      r.name AS role_name, r.label AS role_label,
                      s.course, s.year_level, s.section, s.student_id,
                      s.phone, s.address, s.profile_image, s.student_display_id')
            ->join('roles r', 'r.id = u.role_id', 'left')
            ->join('students s', 's.student_id = u.id', 'left')
            ->where('u.id', $userId)
            ->where('u.deleted_at IS NULL')
            ->get()
            ->getRowArray();
    }

    /**
     * Find a student's record by their user ID (student_id FK).
     */
    public function findByUserId(int $userId): ?array
    {
        return $this->where('student_id', $userId)->first();
    }

    /**
     * Update profile details only — no password change here.
     * Validation is done in the controller before calling this.
     *
     * @param int   $userId
     * @param array $data   Associative array of profile fields
     */
    public function updateProfile(int $userId, array $data): bool
    {
        return $this->skipValidation(true)
                    ->where('student_id', $userId)
                    ->set($data)
                    ->update();
    }
}
