<?php
/*
 * Autor: Mario García - mariogarcia1040@gmail.com
 * Descripción: Modelo para consultar los tickets
 * 08-Octubre-2026 | 13-Octubre-2026
 * 
 */

namespace App\Models;

use CodeIgniter\Model;

class TicketsModel extends Model
{
    public const STATUS_OPEN        = 'abierto';
    public const STATUS_IN_PROGRESS = 'en_proceso';
    public const STATUS_PENDING     = 'pendiente';
    public const STATUS_RESOLVED    = 'resuelto';

    public const ACTIVE_STATUSES = [
        self::STATUS_OPEN,
        self::STATUS_IN_PROGRESS,
        self::STATUS_PENDING,
    ];

    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['subject', 'category_id', 'description', 'status', 'priority', 'applicant_id', 'assigned_id', 'resolved_at'];

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
    protected $validationRules = [
        'subject'      => 'required|max_length[150]',
        'description'  => 'permit_empty|string',
        'category_id'  => 'permit_empty|is_natural_no_zero',
        'status'       => 'required|in_list[abierto,en_proceso,pendiente,resuelto]',
        'priority'     => 'required|in_list[alta,media,baja]',
        'applicant_id' => 'required|is_natural_no_zero',
        'assigned_id'  => 'permit_empty|is_natural_no_zero',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['setResolvedAt'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function setResolvedAt(array $data): array
    {
        if (! isset($data['data']['status'])) {
            return $data;
        }

        $data['data']['resolved_at'] = $data['data']['status'] === self::STATUS_RESOLVED
            ? date('Y-m-d H:i:s')
            : null;

        return $data;
    }

    public function countActive(int $userId, bool $isStaff): int
    {
        $builder = $this->whereIn('status', self::ACTIVE_STATUSES);

        if ($isStaff) {
            $builder->groupStart()
                ->where('assigned_id', $userId)
                ->orWhere('assigned_id', null)
                ->groupEnd();
        } else {
            $builder->where('applicant_id', $userId);
        }

        return $builder->countAllResults();
    }

    public function countByStatus(): array
    {
        $rows = $this->select('status, COUNT(*) AS total')
            ->groupBy('status')
            ->findAll();

        return array_column($rows, 'total', 'status');
    }

    public function scopeFor(\CodeIgniter\Shield\Entities\User $user): array
    {
        return $user->inGroup('admin', 'user') 
            ? []
            : ['applicant_id' => $user->id];
    }
    
}
