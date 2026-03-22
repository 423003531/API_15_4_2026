<?php

// app/Database/Seeds/RoleSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * RoleSeeder
 *
 * Inserts the 3 core roles + 1 challenge role into the roles table.
 *
 * Run with:  php spark db:seed RoleSeeder
 *
 * Role slugs (the 'name' column) must exactly match what your
 * Filter classes compare against:
 *   session('user')['role'] === 'admin'      ← AdminFilter
 *   session('user')['role'] === 'teacher'    ← TeacherFilter
 *   session('user')['role'] === 'student'    ← StudentFilter
 *   session('user')['role'] === 'coordinator'← CoordinatorFilter (challenge)
 */
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $roles = [
            [
                'name'        => 'admin',
                'label'       => 'Administrator',
                'description' => 'Full access to all modules including role management, user assignment, items, and student management.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'teacher',
                'label'       => 'Teacher',
                'description' => 'Access to the main dashboard, student profiles, student management list, and items module.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'name'        => 'student',
                'label'       => 'Student',
                'description' => 'Restricted access to own student dashboard and personal profile page only.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            // ── CHALLENGE ROLE ───────────────────────────────
            // Students must build CoordinatorFilter.php for this role.
            // See the Challenge Task section in the activity sheet.
            [
                'name'        => 'coordinator',
                'label'       => 'Department Coordinator',
                'description' => 'CHALLENGE: Access to everything Teacher can, plus a /coordinator/report page. Requires building CoordinatorFilter.php.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        // insertBatch is faster than looping individual inserts
        $this->db->table('roles')->insertBatch($roles);
    }
}
