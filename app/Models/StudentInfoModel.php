<?php

namespace App\Models;

use App\Models\ApplicationModel;

class StudentInfoModel extends ApplicationModel
{
    protected $table            = 'students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
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
