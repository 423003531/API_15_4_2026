<?php

namespace App\Models;

class ApiTokenModel extends ApplicationModel
{
    protected $table         = 'api_tokens';
    protected $allowedFields = ['user_id', 'token', 'expires_at', 'created_at'];

    public function createToken(int $userId, string $token, string $expiresAt): void
    {
        $this->db->table($this->table)->insert([
            'user_id'    => $userId,
            'token'      => $token,
            'expires_at' => $expiresAt,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function deleteByToken(string $token): void
    {
        $this->db->table($this->table)->where('token', $token)->delete();
    }
}
