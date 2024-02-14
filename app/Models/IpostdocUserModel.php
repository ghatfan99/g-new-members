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
}
