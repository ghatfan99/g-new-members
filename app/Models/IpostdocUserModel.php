<?php

namespace App\Models;

use CodeIgniter\Model;
use Faker\Provider\Base;

class IpostdocUserModel extends BaseModel
{
    protected $table            = 'ipostdoc_users';
    protected $primaryKey       = 'ipostdoc_id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'i_postdoc_der_diplome', 'i_postdoc_etab_der_diplome', 'created_at', 'id_user'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [
        'i_postdoc_der_diplome'         => 'permit_empty|max_length[300]',
        'i_postdoc_etab_der_diplome'    => 'permit_empty|max_length[300]',
        'id_user'                       => 'required|integer|is_unique[ipostdoc_users.id_user]'
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
