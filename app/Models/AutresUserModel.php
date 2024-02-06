<?php

namespace App\Models;

use CodeIgniter\Model;

class AutresUsersModel extends Model
{
    protected $table            = 'autres_users';
    protected $primaryKey       = 'autres_id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'autres_der_diplome', 'autres_etab_der_diplome', 'created_at', 'id_user'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [
        'autres_der_diplome'         => 'permit_empty|max_length[300]',
        'autres_etab_der_diplome'    => 'permit_empty|max_length[300]',
        'id_user'                    => 'required|integer|is_unique[autres_users.id_user]'
    ];
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
}
