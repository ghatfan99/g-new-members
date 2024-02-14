<?php

namespace App\Models;

use CodeIgniter\Model;

class PhdUserModel extends BaseModel
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
}
