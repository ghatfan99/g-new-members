<?php

namespace App\Models;

use CodeIgniter\Model;

class SrvInfoUserModel extends BaseModel
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
}
