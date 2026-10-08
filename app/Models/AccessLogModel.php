<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Model para consutlar los logs de acceso de los usuarios desde la tabla de logins de shield.
 * 08-Octubre-2026
 * 
 */

namespace App\Models;

use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\LoginModel;

class AccessLogModel extends LoginModel
{
    public function recentForUser(User $user, int $limit = 5): array
    {
        return $this->groupStart()
                ->where('user_id', $user->id)
                ->orWhere('identifier', $user->email)
            ->groupEnd()
            ->orderBy('date', 'DESC')
            ->findAll($limit);
    }
}
