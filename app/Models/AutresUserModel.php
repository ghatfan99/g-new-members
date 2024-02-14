<?php

namespace App\Models;

use CodeIgniter\Model;
use Faker\Provider\Base;

class AutresUserModel extends BaseModel
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
}
