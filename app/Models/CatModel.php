<?php

namespace App\Models;

use CodeIgniter\Model;

class CatModel extends Model
{
    protected $table            = 'cats';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'cat_id',
        'name',
        'breed',
        'gender',
        'age',
        'color',
        'is_spayed',
        'favorite_food',
    ];

    // ── Validation ────────────────────────────────────────────────────────────
    protected $validationRules = [
        'cat_id' => 'required|alpha_dash|is_unique[cats.cat_id,id,{id}]|min_length[6]|max_length[8]',
        'name'   => 'required|min_length[2]',
    ];

    protected $validationMessages = [
        'cat_id' => [
            'is_unique'  => 'Sorry, that Pusakat ID is already taken. Each Pusakat needs a unique ID!',
            'required'   => 'Please provide your Pusakat ID (example: CAT-001).',
            'alpha_dash' => 'Bawal ang space sa Pusakat ID. Gamit lang ng letters, numbers, dashes, o underscores.',
            'min_length' => 'Masyadong maikli! Dapat 6 characters pataas ang Pusakat ID.',
            'max_length' => 'Masyadong mahaba! Hanggang 8 characters lang ang pwedeng gamitin.',
        ],
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
}
