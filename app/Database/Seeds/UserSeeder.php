<?php

// app/Database/Seeds/UserSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * UserSeeder
 *
 * Inserts 4 demo user accounts — one per role — for testing RBAC.
 * All accounts use the password: Password1
 *
 * Run with:  php spark db:seed UserSeeder
 *
 * ┌─────────────────────────┬──────────────────────────┬────────────┐
 * │ Role                    │ Email                    │ Password   │
 * ├─────────────────────────┼──────────────────────────┼────────────┤
 * │ Administrator           │ admin@school.edu         │ Password1  │
 * │ Teacher                 │ teacher@school.edu       │ Password1  │
 * │ Student                 │ student@school.edu       │ Password1  │
 * │ Coordinator (challenge) │ coordinator@school.edu   │ Password1  │
 * └─────────────────────────┴──────────────────────────┴────────────┘
 *
 * IMPORTANT: Run RoleSeeder FIRST so role IDs exist before this seeder
 * tries to look them up. Use MainSeeder (which calls both in order) to
 * avoid errors.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        // Look up role IDs dynamically — avoids hard-coded IDs that
        // may differ if the seeder is run on a fresh vs. existing DB
        $getRoleId = function (string $slug): ?int {
            $row = $this->db->table('roles')->where('name', $slug)->get()->getRowArray();
            return $row ? (int) $row['id'] : null;
        };

        // Hash the shared demo password using CI4's recommended approach:
        // password_hash() with PASSWORD_BCRYPT (cost factor defaults to 10)
        // password_verify() should be used to check this hash on login
        $hash = password_hash('Password1', PASSWORD_DEFAULT);

        $users = [
            [
                'fullname'   => 'Admin User',
                'username'   => 'admin@school.edu',
                'password'   => $hash,
                'role'       => 1,
                'role_id'    => $getRoleId('admin'),
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,       // NULL = active (not soft-deleted)
            ],
            [
                'fullname'   => 'Teacher Cruz',
                'username'   => 'teacher@school.edu',
                'password'   => $hash,
                'role'       => 2,
                'role_id'    => $getRoleId('teacher'),
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'fullname'   => 'Student Reyes',
                'username'   => 'student@school.edu',
                'password'   => $hash,
                'role'       => 3,
                'role_id'    => $getRoleId('student'),
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
            [
                'fullname'   => 'Coordinator Bautista',
                'username'   => 'coordinator@school.edu',
                'password'   => $hash,
                'role'       => 4,
                'role_id'    => $getRoleId('coordinator'),
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ],
        ];

        $this->db->table('users')->insertBatch($users);
    }
}
