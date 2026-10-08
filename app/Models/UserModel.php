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
}