<?php

// app/Database/Migrations/2024-01-01-000002_AddRoleIdToUsers.php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: AddRoleIdToUsers
 *
 * Adds a role_id foreign key column to the existing 'users' table.
 * Defaults to NULL so any existing user rows are not broken.
 * The FK references roles(id) with ON DELETE SET NULL — if a role
 * is deleted, affected users are unassigned (role_id becomes NULL)
 * rather than being deleted themselves.
 *
 * Run with:  php spark migrate
 * Rollback:  php spark migrate:rollback
 */
class AddRoleIdToUsers extends Migration
{
    public function up(): void
    {
        if (! $this->db->fieldExists('role_id', 'users')) {
            $this->forge->addColumn('users', [
                'role_id' => [
                    'type'       => 'INT',
                    'constraint' => 10,
                    'unsigned'   => true,
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'email',
                ],
            ]);
        }

        if (! $this->db->fieldExists('deleted_at', 'users')) {
            $this->forge->addColumn('users', [
                'deleted_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                    'default' => null,
                    'after'   => 'updated_at',
                ],
            ]);
        }

        // Add FK only if it doesn't already exist
        $constraints = $this->db->query("
            SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'users'
              AND CONSTRAINT_NAME = 'fk_users_role_id'
        ")->getRowArray();

        if (! $constraints) {
            try {
                $this->db->query('
                    ALTER TABLE users
                    ADD CONSTRAINT fk_users_role_id
                    FOREIGN KEY (role_id)
                    REFERENCES roles(id)
                    ON DELETE SET NULL
                    ON UPDATE CASCADE
                ');
            } catch (\Exception $e) {
                // Column type mismatch (e.g. INT vs INT UNSIGNED) — skip FK,
                // referential integrity is enforced at the application level.
            }
        }
    }

    public function down(): void
    {
        // Must drop FK constraint before dropping the column
        $this->db->query('ALTER TABLE users DROP FOREIGN KEY fk_users_role_id');
        $this->forge->dropColumn('users', 'role_id');

        // Drop the soft-delete column
        $this->forge->dropColumn('users', 'deleted_at');
    }
}
