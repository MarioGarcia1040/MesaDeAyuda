<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Model para la tabla de perfiles de usuario.
 * Tabla: user_profiles
 * Extensión de shield para agregar campos adicionales al perfil de usuario.
 * 05-Octubre-2026 | 12-Octubre-2026
 * 
 */

namespace App\Models;

use CodeIgniter\Model;

class UserProfilesModel extends Model
{
    protected $table            = 'user_profiles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'nombre', 'apellido', 'telefono', 'foto'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
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

    public function findByUserId(int $userId): ?array
    {
        return $this->where('user_id', $userId)->first();
    }

    public function saveForUser(int $userId, array $data): bool
    {
        $profile        = $this->findByUserId($userId);
        $data['user_id'] = $userId;

        return $profile
            ? $this->update($profile['id'], $data)
            : (bool) $this->insert($data);
    }
    
}
