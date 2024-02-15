<?php

namespace App\Models;

use CodeIgniter\Model;
use Faker\Provider\Base;

class AllUsersModel extends BaseModel
{
    protected $table            = 'all_users';
    protected $primaryKey       = 'all_users_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_genre', 'nom', 'prenom', 'nom_patronomique', 'date_naiss', 'ville_naiss', 'num_departement',
        'pays_naiss', 'nationalite', 'adresse', 'ville_cp', 'pays', 'tel_mobile', 'auth_photo_int',
        'auth_photo_ext', 'created_at', 'id_user'
    ];


    // sauvegarde des données
    public function saveData($data)
    {
        if (!empty($data)) {
            return $this->insert($data);
        }
        return false;
    }

    // Autres méthodes
    // Obtenir tous les utilisateurs avec type phd
    public function getAllUsersWithPhd()
    {
        return $this->db->table('all_users')
            ->select('all_users.*, phd_users.*, users.email')
            ->join('phd_users', 'all_users.id_user = phd_users.id_user')
            ->join('users', 'all_users.id_user = users.id_user')
            ->get()
            ->getResult();
    }

    // Obtenir tous les utilisateurs avec type EC
    public function getAllUsersWithEc()
    {
        return $this->db->table('all_users')
            ->select('all_users.*, ch_ec_users.*, users.email')
            ->join('ch_ec_users', 'all_users.id_user = ch_ec_users.id_user')
            ->join('users', 'all_users.id_user = users.id_user')
            ->get()
            ->getResult();
    }

    // Obtenir tous les utilisateurs avec type Ipostdoc
    public function getAllUsersWithIpostdoc()
    {
        return $this->db->table('all_users')
            ->select('all_users.*, ipostdoc_users.*, users.email')
            ->join('ipostdoc_users', 'all_users.id_user = ipostdoc_users.id_user')
            ->join('users', 'all_users.id_user = users.id_user')
            ->get()
            ->getResult();
    }


    // Obtenir tous les utilisateurs avec type autres
    public function getAllUsersWithAutres()
    {
        return $this->db->table('all_users')
            ->select('all_users.*, autres_users.autres_der_diplome, autres_users.autres_etab_der_diplome, users.email')
            ->join('autres_users', 'all_users.id_user = autres_users.id_user')
            ->join('users', 'all_users.id_user = users.id_user')
            ->get()
            ->getResult();
    }

    // Function pour voir si l'utilisateur exist or not
    public function userExists($id_user)
    {
        return $this->where('id_user', $id_user)->countAllResults() > 0;
    }

    // Obtenir tous les pays
    public function getAllCountries()
    {
        $url = $this->getSiloseUrl() . '/pays';
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }

    public function getPays($code_iso_pays)
    {
        $url = $this->getSiloseUrl() . '/pays/exact/code_iso_pays/' . $code_iso_pays;
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }

    // Obtenir tous les départements
    public function getAllDepartments()
    {
        $url = $this->getSiloseUrl() . '/departements/order/num_departement';
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }

    public function getDepartment($num_departement)
    {
        $url = $this->getSiloseUrl() . '/departements/exact/num_departement/' . $num_departement;
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }
}
