<?php

namespace App\Models;

use CodeIgniter\Model;
use Faker\Provider\Base;

class NewUsersModel extends BaseModel
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nom', 'prenom', 'password', 'email', 'date_debut', 'date_fin', 'na_status',
        'actif', 'role', 'token', 'verified', 'created_at'
    ];
}
