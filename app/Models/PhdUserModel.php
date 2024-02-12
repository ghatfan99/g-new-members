<?php

namespace App\Models;

use CodeIgniter\Model;

class PhdUsersModel extends BaseModel
{
    protected $table            = 'phd_users';
    protected $primaryKey       = 'phd_id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_ecole_doctorale', 'titre_these', 'phd_der_diplome', 'phd_etab_der_diplome', 'created_at', 'id_user'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [
        'id_ecole_doctorale'    => 'permit_empty|integer', // Assuming it's an integer representing the school ID
        'titre_these'           => 'permit_empty|max_length[300]', // Assuming the maximum length is 300 characters
        'phd_der_diplome'       => 'permit_empty|max_length[300]', // Assuming the maximum length is 300 characters
        'phd_etab_der_diplome'  => 'permit_empty|max_length[300]', // Assuming the maximum length is 300 characters
        'id_user'               => 'required|integer|is_unique[phd_users.id_user]'
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
