<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use App\Models\AllUsersModel;
use App\Models\NewUsersModel;
use App\Models\ArrivantModel;
use App\Models\AutresUserModel;
use App\Models\EcUserModel;
use App\Models\IpostdocUserModel;
use App\Models\PhdUserModel;
use CodeIgniter\API\ResponseTrait;

class Users extends BaseController
{
    use ResponseTrait;

    protected $required_message = 'Ce champs est obligatoire';
    protected $min_length_message = 'Le mot de passe doit avoir 5 caractères au moins';
    protected $max_length_message = 'Le mot de passe ne doit pas avoir plus de 12 caractères';

    public $data = [];
    // le constructeur
    public function __construct()
    {
        helper(['url']);
    }

    public function all_users()
    {
        helper(['url']);
        $allUsersModel = new AllUsersModel();
        $ecUserModel = new EcUserModel();
        // Data sent to the view
        $data = ['title' => 'Tous Les nouveaux arrivants'];
        $autresData = $allUsersModel->getAllUsersWithAutres();
        $phdData = $allUsersModel->getAllUsersWithPhd();
        $ecData = $allUsersModel->getAllUsersWithEc();
        $iposdocData = $allUsersModel->getAllUsersWithIpostdoc();
        // get details of ids (corps_grade, section, discipline) for the chercheurs EC
        foreach ($ecData as $key => $entry) {
            // Assuming ids exists in $ecData
            $id_section = $entry->id_section;
            $id_corps_grade = $entry->id_corps_grade;
            $id_ecole_doc = $entry->id_ecole_doctorale;

            // Fetch the corps grade  details
            $corps_gradeDetails = $ecUserModel->getCorpGrade($id_corps_grade);
            // Fetch the section details
            $sectionDetails = $ecUserModel->getSectionsPrincipales($id_section);
            // Fetch the ecole doctorale details
            $ecole_docDetails = $ecUserModel->getEecoleDoctorales($id_ecole_doc);
            $nationalite = $entry->nationalite;
            $nationalite_details = $allUsersModel->getPays($nationalite);
            $ecData[$key]->nationalite_details = $nationalite_details;

            // Replace the 'ids' with the fetched details
            $ecData[$key]->section_details = $sectionDetails;
            $ecData[$key]->corps_grade_details = $corps_gradeDetails;
            $ecData[$key]->ec_doc_details = $ecole_docDetails;
        }
        // ***
        // get details of ids for the PhD
        foreach ($phdData as $key => $entry) {
            // Assuming ids exists in $phdData
            $id_ecole_doc = $entry->id_ecole_doctorale;
            // Fetch the corps grade  details
            $ecole_docDetails = $ecUserModel->getEecoleDoctorales($id_ecole_doc);

            $nationalite = $entry->nationalite;
            $nationalite_details = $allUsersModel->getPays($nationalite);
            $phdData[$key]->nationalite_details = $nationalite_details;

            // Replace the 'ids' with the fetched details
            $phdData[$key]->phd_doc_details = $ecole_docDetails;
        }
        // ***
        // get details of ids for the ing /postdoc
        foreach ($iposdocData as $key => $entry) {
            $nationalite = $entry->nationalite;
            $nationalite_details = $allUsersModel->getPays($nationalite);
            $iposdocData[$key]->nationalite_details = $nationalite_details;
        }
        // ***
        // get details of ids for Autre/others
        foreach ($autresData as $key => $entry) {
            $nationalite = $entry->nationalite;
            $nationalite_details = $allUsersModel->getPays($nationalite);
            $autresData[$key]->nationalite_details = $nationalite_details;
        }
        // ***
        $data['autres'] = $autresData;
        $data['phd'] = $phdData;
        $data['ec'] = $ecData;
        $data['ipostdoc'] = $iposdocData;
        //        var_dump($data['autres']);
        //        exit;

        return view('arrivants/liste_arrivants', $data);
    }
}
