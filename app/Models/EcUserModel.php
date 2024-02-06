<?php

namespace App\Models;

use CodeIgniter\Model;

class EcUserModel extends Model
{
    protected $table            = 'ch_ec_users';
    protected $primaryKey       = 'ch_ec_id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_corps_grade', 'code_type_section', 'id_section', 'id_ecole_doctorale',
        'id_discipline', 'ec_date_hdr', 'ec_imm_pui_fis', 'created_at', 'id_user'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [
        'id_corps_grade'        => 'permit_empty|integer',
        'code_type_section'     => 'permit_empty|max_length[15]',
        'id_section'            => 'permit_empty|integer',
        'id_ecole_doctorale'    => 'permit_empty|integer',
        'id_discipline'         => 'permit_empty|integer',
        'ec_date_hdr'           => 'permit_empty|valid_date[Y-m-d]',
        'ec_imm_pui_fis'        => 'permit_empty|max_length[255]',
        'id_user'               => 'required|integer|is_unique[ch_ec_users.id_user]'
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

    /**
     * Obtenir les corps grades depuis SILOSE
     * et un corps grade avec l'id
     */
    public function getAllCorpGrade()
    {
        $url = $this->getSiloseUrl() . '/corps_grades';
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }

    // Obtenir un corps grade avec l'id
    public function getCorpGrade($id_corpsGrade)
    {
        $url = $this->getSiloseUrl() . '/corps_grades/exact/id_corps_grade/' . $id_corpsGrade;
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }
    // ****************************************************************************************
    /**
     * Obtenir les types sections et un type section avec l'id
     */
    public function getAllTypesSection()
    {
        $url = $this->getSiloseUrl() . '/type_sections';
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }
    public function getTypeSection($code_type_section)
    {
        $url = $this->getSiloseUrl() . '/type_sections/exact/code_type_section/' . $code_type_section;
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }
    // ****************************************************************************************


    /**
     * @return mixed
     * Obtenir les section et un section par son id
     */
    public function getAllSectionsPrincipales()
    {
        $url = $this->getSiloseUrl() . '/sections';
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }

    public function getSectionsPrincipales($id_section)
    {
        $url = $this->getSiloseUrl() . '/sections/exact/id_section/' . $id_section;
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }
    // ****************************************************************************************

    /**
     * @return mixed
     * Obtenir les disciplines depuis SILOSE
     * et un discipline par son id
     */
    public function getAllDiscipline()
    {
        $url = $this->getSiloseUrl() . '/disciplines';
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }

    public function getDiscipline($idDiscipline)
    {
        $url = $this->getSiloseUrl() . '/disciplines/exact/id_discipline/' . $idDiscipline;
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }
    // ****************************************************************************************

    /**
     * @return mixed
     * Obtenir toutes les écoles doctorales
     * et une école doctorale par son id dépuis SILOSE
     */
    public function getAllEecoleDoctorales()
    {
        $url = $this->getSiloseUrl() . '/ecole_doctorales';
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }

    public function getEecoleDoctorales($idED)
    {
        $url = $this->getSiloseUrl() . '/ecole_doctorales/exact/id_ecole_doctorale/' . $idED;
        $output = $this->getDataCURL($url);
        //check array json
        if ($this->checkInStringIsJsonArray($output) == false) {
            $output = $this->convertInStringIsJsonArray($output);
        }
        return json_decode($output, true);
    }
    // ****************************************************************************************
}
