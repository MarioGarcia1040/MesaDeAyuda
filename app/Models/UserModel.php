<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Model para consutlar email de la tabla auth_identities de shield.
 * 08-Octubre-2026
 * 
 */

namespace App\Models;

use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    public function emailInUse(string $email, int $exceptUserId): bool
    {
        return $this->db->table('auth_identities')
            ->where('type', Session::ID_TYPE_EMAIL_PASSWORD)
            ->where('secret', $email)
            ->where('user_id !=', $exceptUserId)
            ->countAllResults() > 0;
    }

    public function getUsersWithProfileDetails(): array
    {
        return $this->select("
            users.*,
            user_profiles.nombre,
            user_profiles.apellido,
            user_profiles.telefono,
            user_profiles.foto,
            users.created_at AS register_date,
            ai.secret AS email,
            (
                SELECT GROUP_CONCAT(
                    agu.`group`
                    ORDER BY agu.`group`
                    SEPARATOR ','
                )
                FROM auth_groups_users agu
                WHERE agu.user_id = users.id
            ) AS grupos
        ", false)
            ->join('user_profiles', 'user_profiles.user_id = users.id', 'left')
            ->join(
                'auth_identities ai',
                "ai.user_id = users.id AND ai.type = 'email_password'",
                'left'
            )
            ->findAll();
    }

}
