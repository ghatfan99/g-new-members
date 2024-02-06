<?php

namespace App\Models;

use CodeIgniter\Model;

class SrvInfoModel extends Model
{
    protected $table            = 'srv_info';
    protected $primaryKey       = 'id_srv_info';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'system_exp', 'config_materiel', 'logiciels_spec', 'explication', 'additional_informations',
        'created_at', 'id_user'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [
        'system_exp'                => 'permit_empty',
        'config_materiel'           => 'permit_empty',
        'logiciels_spec'            => 'permit_empty|max_length[300]',
        'explication'               => 'permit_empty',
        'additional_informations'   => 'permit_empty',
        'id_user'                   => 'required|integer|is_unique[srv_info.id_user]'
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
