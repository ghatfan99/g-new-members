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

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [
        'nom'       => 'required',
        'prenom'    => 'required',
        'password'  => 'required|min_length[12]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/]|no_repeating_chars',
        'email'     => 'required|valid_email|is_unique[users.email]',
        'date_debut' => 'valid_date',
        'date_fin'  => 'valid_date',
        'na_status' => 'required',
        'actif'     => 'required|in_list[t,f]',
        'role'      => 'required|in_list[t,f]',
        'token'     => 'permit_empty|max_length[255]',
        'verified'  => 'required|in_list[t,f]',
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
