<?php

namespace App\Controllers;

use App\Controllers\BaseController;
// Libraries
use App\Libraries\Hash;
use Config\Paths;
use TCPDF;
// *******************************
// Models
use App\Models\AllUsersModel;
use App\Models\NewUsersModel;
use App\Models\AutresUserModel;
use App\Models\EcUserModel;
use App\Models\IpostdocUserModel;
use App\Models\PhdUserModel;
use App\Models\SrvInfoUserModel;
use App\Services\UserService;
// APIs
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Request;
use CodeIgniter\Security\Security;

class User extends BaseController
{
    use ResponseTrait;

    protected $required_message = 'Ce champs est obligatoire';
    public $data = [];
    // New User model
    protected $newUserModel;

    protected $ecoleDoctoralesData;

    private $logged_user_id;
    private $logged_user_statut;

    public function __construct()
    {
        helper(['curl', 'session', 'url', 'form', 'Form_helper.php', 'Pdf_helper.php', 'Email_helper.php']);
        $this->logged_user_id = session()->get('id_logged_user');
        $this->logged_user_statut = session()->get('statut_logged_user');
        $this->newUserModel = new NewUsersModel();
    }
    // page de formulaire utilisateur
    public function index()
    {
        // tous les pays
        $allUsersModel = new AllUsersModel();
        $paysData = $allUsersModel->getAllCountries();
        // tous les departements
        $departementsData = $allUsersModel->getAllDepartments();

        // Le model EcUserModel
        $ecUsersModel = new EcUserModel();
        // Les corps grades
        $corpsGradeData = $ecUsersModel->getAllCorpGrade();
        // les types sections
        $typeSectionData = $ecUsersModel->getAllTypesSection();
        // les sections
        $sectionData = $ecUsersModel->getAllSectionsPrincipales();
        // les écoles doctorales
        $ecoleDoctoralesData = $ecUsersModel->getAllEecoleDoctorales();
        // les disciplines
        $disciplinesData = $ecUsersModel->getAllDiscipline();
        // Data sent to the view
        $data = ['title' => 'Dashboard'];
        // *****************************
        // Pays and departments
        $data['pays'] = $paysData;
        $data['departements'] = $departementsData;
        // *****************************
        $data['corps_grade'] = $corpsGradeData;
        $data['type_sections'] = $typeSectionData;
        $data['sections'] = $sectionData;
        $data['ecole_doctorales'] = $ecoleDoctoralesData;
        $data['disciplines'] = $disciplinesData;


        // Obtenir les informations partagées par touts les utilisateurs 
        $user_shared_info = UserService::getUserSharedInfo($this->logged_user_id);
        if (!empty($user_shared_info) && is_array($user_shared_info)) {
            $data['user_shared_info'] = $user_shared_info;
            $data['shared_info'] = true;
        }

        $user_statut_info = UserService::getUserInfoStatut($this->logged_user_id, $this->logged_user_statut);
        if (!empty($user_statut_info) && is_array($user_statut_info)) {
            $data['user_statut_info'] = $user_statut_info;
            $data['statut_info'] = true;
        }

        $user_srv_info = UserService::getUserInfoSrvInfo($this->logged_user_id);
        if (!empty($user_srv_info) && is_array($user_srv_info)) {
            $data['user_srv_info'] = $user_srv_info;
            $data['srv_info'] = true;
        }
        // Return the view with the complete $data array
        // var_dump($data);
        return view('user/user', $data);
    }

    // Submit the user information form
    public function save_data()
    {
        // Obtenir le statut de l'utilisateur connecté
        $status = $this->logged_user_statut;
        $id_user = $this->logged_user_id;
        // Models
        $allUsersModel = new AllUsersModel();
        $srvUserModel = new SrvInfoUserModel();
        $phdModel = new PhdUserModel();
        $autresModel = new AutresUserModel();
        $ippostdocModel = new IpostdocUserModel();
        $chercheurEcModel = new EcUserModel();
        // ***************************************
        /**
         * Tester si l'utilisateur existe pour après décider sleon le button
         * click save draft, où enregistrer.
         * Dans les deux cas brouillon et enregistrer il faut tester l'existance de l'utilisteur.
         * Dans le cas d'enregistrer :
         * 1. Appliquer les rules de validation
         * 2. Générer les fichiers pdf et envoyer les mails vers les deux service RH et Info        
         * 3. Envoyer les informations vers SILOSE (table: ext-arrivants) avec l'API SILOSE
         * */
        $isUserExist = $allUsersModel->userExists($id_user);
        // ***************************************
        $new_user_data = [];
        // ***************************************
        // L'utilisateur va mettre à jour les données qui existent déjà
        // Les données partagées par tous le monde
        $departement = $allUsersModel->getDepartment($this->request->getPost('depNaiss'));
        $pays = $allUsersModel->getPays($this->request->getPost('paysNaiss'));
        $nationaliteUser = $allUsersModel->getPays($this->request->getPost('nationalite'));
        $user_genre = securestring($this->request->getPost('genre'));
        $nom = securestring($this->request->getPost('nom'));
        $prenom = securestring($this->request->getPost('prenom'));
        $nom_patronomique = securestring($this->request->getPost('nomPatronomique'));
        $date_naiss = $this->request->getPost('dateNaiss');

        $sharedData = [
            'user_genre' => $user_genre,
            'nom' => $nom,
            'prenom' => $prenom,
            'nom_patronomique' => $nom_patronomique,
            'date_naiss' => $date_naiss,
            'ville_naiss' => securestring($this->request->getPost('villeNaiss')),
            'departementVal' => !empty($departement) && is_array($departement) ? $departement[0]["nom_departement"] : '',
            'num_departement' => $this->request->getPost('depNaiss'),
            'paysVal' => !empty($pays) && is_array($pays) ? $pays[0]["pays"] : '',
            'pays_naiss' => $this->request->getPost('paysNaiss'),
            'nationaliteVal' => !empty($nationaliteUser) && is_array($nationaliteUser) ? $pays[0]["nationalite"] : '',
            'nationalite' => $this->request->getPost('nationalite'),
            'adresse' => securestring($this->request->getPost('adresse')),
            'ville_cp' => securestring($this->request->getPost('cpVille')),
            'pays' => $this->request->getPost('paysAdresse'),
            'emailPers' => securestring($this->request->getPost('emailPers')),
            'tel_mobile' => securestring($this->request->getPost('telMobile')),
            'auth_photo_int' => $this->request->getPost('authPhotoInt'),
            'auth_photo_ext' => $this->request->getPost('authPhotoExt'),
            'id_user' => $this->logged_user_id
        ];
        // Ajouter les données partagées
        $new_user_data['shared_data'] = $sharedData;
        //************************************************************ */
        //        var_dump($_POST);
        //        exit;
        // Les données du service informatique
        $srvData = [
            'system_exp' => securestring(trim($this->request->getPost('operationSystem'))),
            'config_materiel' => securestring(trim($this->request->getPost('confMateriel'))),
            'logiciels_spec' => securestring(trim($this->request->getPost('specific_software'))),
            'explication' => securestring(trim($this->request->getPost('explication'))),
            'additional_informations' => securestring(trim($this->request->getPost('additional_informations'))),
            'id_user' => $this->logged_user_id
        ];
        $new_user_data['srvData'] = $srvData;
        //************************************************************ */
        // Les données selon le statut de la personne
        switch ($status) {
            case 'phd':
                $id_ecole_doctorale = $this->request->getPost('ecoleDoc');
                $nameEC = $chercheurEcModel->getEecoleDoctorales($id_ecole_doctorale);
                $nomEdValue = !empty($nameEC) && is_array($nameEC) ? $nameEC[0]["nom_ed"] : '';
                $phdData = [
                    'id_ecole_doctorale' => $id_ecole_doctorale,
                    'nom_ed' => $nomEdValue,
                    'titre_these' => securestring($this->request->getPost('titreThese')),
                    'phd_der_diplome' => securestring($this->request->getPost('phdDerDiplome')),
                    'phd_etab_der_diplome' => securestring($this->request->getPost('phdEtabDerDiplome')),
                    'id_user' => $this->logged_user_id
                ];
                $new_user_data['phdData'] = $phdData;
                // Logic to update draft for PhdModel
                break;
            case 'autres':
                $autresData = [
                    'autres_der_diplome' => securestring($this->request->getPost('derDiplomeAutres')),
                    'autres_etab_der_diplome' => securestring($this->request->getPost('etabDerDiplomeAutres')),
                    'id_user' => $this->logged_user_id
                ];
                $new_user_data['autresData'] = $autresData;
                break;
            case 'ipostdoc':
                $ippostdocData = [
                    'i_postdoc_der_diplome' => securestring($this->request->getPost('iPostdocDerDiplome')),
                    'i_postdoc_etab_der_diplome' => securestring($this->request->getPost('iPostDocEtabDerDiplomeI')),
                    'id_user' => $this->logged_user_id
                ];
                $new_user_data['ippostdocData'] = $ippostdocData;
                break;
            case 'chercheurEc':
                // corps_grade
                $id_corps_grade = $this->request->getPost('corpsGrade');
                $corp_grade = $chercheurEcModel->getCorpGrade($id_corps_grade);
                $corp_gradeValue = !empty($corp_grade) && is_array($corp_grade) ? $corp_grade[0]["code_corps_grade"] . ' - ' . $corp_grade[0]["nom_corps_grade"] : '';
                // Ecole doctorale
                $id_ecole_doctorale = $this->request->getPost('ecoleDocEC');
                $nameEC = $chercheurEcModel->getEecoleDoctorales($id_ecole_doctorale);
                $nomEdValue = !empty($nameEC) && is_array($nameEC) ? $nameEC[0]["nom_ed"] : '';
                // Type section
                $code_type_section = $this->request->getPost('typeSectionPrincipal');
                $nameTypeSection = $chercheurEcModel->getTypeSection($code_type_section);
                $nomTypeSectionValue = !empty($nameTypeSection) && is_array($nameTypeSection) ? $nameTypeSection[0]["nom_type_section"] : '';
                // section
                $id_section = $this->request->getPost('sectionPrincipale');
                $nameSection = $chercheurEcModel->getSectionsPrincipales($id_section);
                $nomSectionValue = !empty($nameSection) && is_array($nameSection) ? $nameSection[0]["nom_section"] : '';
                // Discipline
                $id_discipline = $this->request->getPost('disciplineEC');
                $discipline = $chercheurEcModel->getDiscipline($id_discipline);
                $disciplineValue = !empty($discipline) && is_array($discipline) ? $discipline[0]["code_discipline"] . ' - ' . $discipline[0]["discipline"] : '';
                $ecData = [
                    'id_corps_grade' => $id_corps_grade,
                    'corps_grade' => $corp_gradeValue,
                    'code_type_section' => $code_type_section,
                    'nom_type_section' => $nomTypeSectionValue,
                    'id_section' => $id_section,
                    'nom_section' => $nomSectionValue,
                    'id_ecole_doctorale' => $id_ecole_doctorale,
                    'nom_ed' => $nomEdValue,
                    'id_discipline' => $this->request->getPost('disciplineEC'),
                    'discipline' => $disciplineValue,
                    'ec_date_hdr' => $this->request->getPost('dateHDR'),
                    'ec_imm_pui_fis' => securestring($this->request->getPost('immPuiFisCEC')),
                    'id_user' => $this->logged_user_id
                ];
                $new_user_data['chercheurEcData'] = $ecData;
                break;
                // Add other cases as needed
            default:
                // Handle default case
                break;
        }
        //************************************************************ */
        //************************************************************ */
        if ($this->request->getPost('save_draft') !== null) {
            echo "save draft button is clicked, isupdate = " . $isUserExist . "<br>";
            // L'utilisateur va mettre à jour les données qui existent déjà           
            // if ($isUpdate) {
            if ($isUserExist) {
                // echo "update draft method, draft already exist";
                $sharedResult = $allUsersModel->set($sharedData)->where('id_user', $this->logged_user_id)->update();
                //************************************************************ */
                $srvResult  = $srvUserModel->set($srvData)->where('id_user', $this->logged_user_id)->update();
                //************************************************************ */
                // Les données selon le statut de la personne
                switch ($status) {
                    case 'phd':
                        echo "Phd update for existing data";
                        $statutResult = $phdModel->set($phdData)->where('id_user', $this->logged_user_id)->update();
                        break;
                    case 'autres':
                        echo "Autres update for existing data";
                        $statutResult = $autresModel->set($autresData)->where('id_user', $this->logged_user_id)->update();
                        break;
                    case 'ipostdoc':
                        echo "IPostdoc update for existing data";
                        $statutResult = $ippostdocModel->set($ippostdocData)->where('id_user', $this->logged_user_id)->update();
                        break;
                    case 'chercheurEc':
                        echo "Chercheurs, EC update for existing data";
                        $statutResult = $chercheurEcModel->set($ecData)->where('id_user', $this->logged_user_id)->update();
                        break;
                        // Add other cases as needed
                    default:
                        // Handle default case
                        break;
                }
                // Check if any update operation failed
                if ($sharedResult && $srvResult && $statutResult) {
                    // All updates were successful, redirect with success message
                    return redirect()->to('/user')->with('success', 'Vos données temporaires sont enregistrées avec succès!');
                } else {
                    // At least one update failed, redirect with error message
                    return redirect()->to('/user')->with('error', 'Desolé, une erreur est survenue lors de l\'enregistrement de vos données');
                }
            } else {
                // L'utilisateur va saveguarder ses données de brouillon pour la permière fois
                $sharedResult = $allUsersModel->insert($sharedData);
                //************************************************************ */
                $srvResult  = $srvUserModel->insert($srvData);
                //************************************************************ */
                // Les données selon le statut de la personne
                switch ($status) {
                    case 'phd':
                        $statutResult = $phdModel->insert($phdData);
                        break;
                    case 'autres':
                        $statutResult = $autresModel->insert($autresData);
                        break;
                    case 'ipostdoc':
                        $statutResult = $ippostdocModel->insert($ippostdocData);
                        break;
                    case 'chercheurEc':
                        $statutResult = $chercheurEcModel->insert($ecData);
                        break;
                    default:
                        // Handle default case
                        break;
                }
                // Check if any update operation failed
                if ($sharedResult && $srvResult && $statutResult) {
                    // All updates were successful, redirect with success message
                    return redirect()->to('/user')->with('success', 'Vos données temporaires sont enregistrées avec succès!');
                } else {
                    // At least one update failed, redirect with error message
                    return redirect()->to('/user')->with('error', 'Desolé, une erreur est survenue lors de l\'enregistrement de vos données');
                }
            }
        } else {
            $validation = \Config\Services::validation();

            $commonRules = [
                'genre' => [
                    'label' => 'Genre',
                    'rules' => 'required',
                    'errors' => [
                        'required' => $this->required_message
                    ]
                ],
                'nom' => [
                    'label' => 'Nom',
                    'rules' => 'required',
                    'errors' => [
                        'required' => $this->required_message
                    ]
                ],
                'prenom' => [
                    'label' => 'Prénom',
                    'rules' => 'required',
                    'errors' => [
                        'required' => $this->required_message
                    ]
                ],
                'dateNaiss' => [
                    'label' => 'Date de naissance',
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required' => $this->required_message,
                        'valid_date' => "La date n'est pas valide"
                    ]
                ],
                'paysNaiss' => [
                    'label' => 'Pays de naissance',
                    'rules' => 'required',
                    'errors' => [
                        'required' => $this->required_message
                    ]
                ],
                'nationalite' => [
                    'label' => 'Nationalité',
                    'rules' => 'required',
                    'errors' => [
                        'required' => $this->required_message
                    ]
                ],
                'emailPers' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => $this->required_message,
                        'valid_email' => 'Cette adresse mail n\'est pas valide',
                        'is_unique' => 'Cette adresse mail est déjà utilisée'
                    ]
                ]
            ];

            $statutOption = trim($this->request->getPost('statutOptions'));
            if ($statutOption === 'phd') {
                $phdRules = [
                    // Define rules specific to 'phd'
                    'ecoleDoc' => [
                        'label' => 'Ecole doctorale',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'L\'école doctorale est obligatoire'
                        ]
                    ],
                    'titreThese' => [
                        'label' => 'Titre de thèse',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Le titre de thèse est obligatoire'
                        ]
                    ],
                    'phdEtabDerDiplome' => [
                        'label' => 'Etablissement de dernier diplôme',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'L\'établissement de dernier diplôme est obligatoire'
                        ]
                    ],
                    'phdDerDiplome' => [
                        'label' => 'Dernier diplôme',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Le dernier diplôme est obligatoire'
                        ]
                    ],
                ];
                $validation->setRules(array_merge($commonRules, $phdRules));
                // Les règles de validation pour les chercheurs et ensegiants chercheurs
            } elseif ($statutOption === 'chercheurEc') {
                $chercheurEcRules = [
                    'corpsGrade' => [
                        'label' => 'Corps-Grade',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Le champs Coprs-Grade est obligatoire'
                        ]
                    ],
                    'titreThese' => [
                        'label' => 'Titre de thèse',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Le titre de thèse est obligatoire'
                        ]
                    ],
                    'phdEtabDerDiplome' => [
                        'label' => 'Etablissement de dernier diplôme',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'L\'établissement de dernier diplôme est obligatoire'
                        ]
                    ],
                    'phdDerDiplome' => [
                        'label' => 'Dernier diplôme',
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Le dernier diplôme est obligatoire'
                        ]
                    ],
                ];
                $validation->setRules(array_merge($commonRules, $chercheurEcRules));
            } else {
                $validation->setRules($commonRules);
            }

            if (!$validation) {
                $data["validation"] = $this->validator;
                $data["user"] = $this->data["user"];
                $data["pageTitle"] = 'Nouveau arrivant';
                $data["user_info"] = $this->data['user_info'];

                return view('user/user', $data);
            } else {
                if ($isUserExist) {
                    // test
                    //                    var_dump($new_user_data);
                    //                    exit;
                    $sharedResult = $allUsersModel->set($sharedData)->where('id_user', $this->logged_user_id)->update();
                    //************************************************************ */
                    $srvResult  = $srvUserModel->set($srvData)->where('id_user', $this->logged_user_id)->update();
                    //************************************************************ */
                    // Les données selon le statut de la personne
                    switch ($status) {
                        case 'phd':
                            echo "Phd update for existing data";
                            $statutResult = $phdModel->set($phdData)->where('id_user', $this->logged_user_id)->update();
                            break;
                        case 'autres':
                            echo "Autres update for existing data";
                            $statutResult = $autresModel->set($autresData)->where('id_user', $this->logged_user_id)->update();
                            break;
                        case 'ipostdoc':
                            echo "IPostdoc update for existing data";
                            $statutResult = $ippostdocModel->set($ippostdocData)->where('id_user', $this->logged_user_id)->update();
                            break;
                        case 'chercheurEc':
                            echo "Chercheurs, EC update for existing data";
                            $statutResult = $chercheurEcModel->set($ecData)->where('id_user', $this->logged_user_id)->update();
                            break;
                            // Add other cases as needed
                        default:
                            // Handle default case
                            break;
                    }
                    // Check if any update operation failed
                    if ($sharedResult && $srvResult && $statutResult) {
                        if (session()->has('form_submitted')) {
                            // Handle duplicate submission or redirect to an error page
                            return redirect()->to('/user/user_confirmation')->with('fail', 'Vos données sont déjà enregistrées. Une erreur s\'est produite lors de l\'enregistrement des données. Veuillez contacter le service RH pour réactiver votre compte / Your data are already saved. An error occurred while saving the data. Please contact the HR department to reactivate your account');
                        } else {
                            // Mark the form as submitted in the session
                            session()->set('form_submitted', true);
                            // Redirect to the confirmation page after successful form submission
                            /**
                             * Afin d'empêcher l'utilisateur de se reconnecter à l'application, on met son
                             * compte actif à false avant de le rediriger vers la page de confirmation
                             *  */
                            //                            var_dump($new_user_data);
                            //                            exit;
                            $pdfRH = generatePdfRH($new_user_data, $status);
                            $pdfSI = generatePdfSI($new_user_data, $status);
                            $file_path = Paths::PDF_USERS_FILES;
                            $name_file_rh = $file_path . 'service_rh_' . $nom . '_' . $prenom . '.pdf';
                            $name_file_info = $file_path . 'service_info_' . $nom . '_' . $prenom . '.pdf';
                            if (is_dir($file_path)) {
                                if ($pdfSI->Output($name_file_info, 'F') === false || $pdfRH->Output($name_file_rh, 'F') === false) {
                                    echo "Pdf generation failed. check for errors";
                                } else {
                                    echo "PDF generated and saved successfully!";
                                    $recipients = ['hasan_hazem@hotmail.com', 'hazem.hasan@grenoble-inp.fr'];
                                    $subject = 'Arrivée de ' . $user_genre . '. ' . ucwords($nom) . ' ' . $prenom;
                                    $message = '<p>Bonjour,</p>
                                                <p><strong>Veuillez trouver ci-joint les informations relatives à son arrivée.</strong></p>
                                                <p>Nous vous prions de prendre les dispositions nécessaires du côté du Service RH pour son intégration et du Service Informatique pour la configuration de son espace de travail.</p>
                                                <p>N\'hésitez pas à prendre contact avec lui  pour le féliciter et lui souhaiter la bienvenue.</p>
                                                <br>
                                                <p><em>Cordialement,</em><br>
                                                Nouveaux arrivants<br>
                                                Service SMIT / DEV<br>
                                                Laboratoire G-SCOP</p>';
                                    $attachment_rh = $name_file_rh;
                                    $attachment_si = $name_file_info;
                                    $email_si = send_email($recipients[0], $subject, $message, $attachment_si);
                                    $email_rh = send_email($recipients[1], $subject, $message, $attachment_rh);
                                    if ($email_rh === true && $email_si === true) {
                                        $userActifUpdate = $this->newUserModel->set(['actif' => 'f'])->where('id_user', $this->logged_user_id)->update();
                                        if ($userActifUpdate) {
                                            return redirect()->to(base_url('/user/user_confirmation'))->with('success', 'Vos données sont enregistrées et envoyées aux servics G-GSCOP avec succès!');
                                        }
                                    } else {
                                        return redirect()->to('/user')->with('error', 'Desolé, une erreur est survenue lors de l\'enregistrement de vos données dans notre système');
                                    }
                                }
                            } else {
                                echo "Directory does not exist or insufficient permissions.";
                            }
                        }
                    } else {
                        // At least one update failed, redirect with error message
                        return redirect()->to('/user')->with('error', 'Desolé, une erreur est survenue lors de l\'enregistrement de vos données');
                    }
                } else {
                    // L'utilisateur va saveguarder et envoyer ses données dès la permière fois
                    $sharedResult = $allUsersModel->insert($sharedData);
                    //************************************************************ */
                    $srvResult  = $srvUserModel->insert($srvData);
                    //************************************************************ */
                    // Les données selon le statut de la personne
                    switch ($status) {
                        case 'phd':
                            $statutResult = $phdModel->insert($phdData);
                            break;
                        case 'autres':
                            $statutResult = $autresModel->insert($autresData);
                            break;
                        case 'ipostdoc':
                            $statutResult = $ippostdocModel->insert($ippostdocData);
                            break;
                        case 'chercheurEc':
                            $statutResult = $chercheurEcModel->insert($ecData);
                            break;
                        default:
                            // Handle default case
                            break;
                    }
                    // Check if any insertion operation failed
                    if ($sharedResult && $srvResult && $statutResult) {
                        // All insertions were done successfully, redirect with success message
                        /**
                         * Afin d'empêcher l'utilisateur de se reconnecter à l'application, on met son 
                         * compte actif à false avant de le rediriger vers la page de confirmation
                         *  */
                        $userActifUpdate = $this->newUserModel->set(['actif' => 'f'])->where('id_user', $this->logged_user_id)->update();
                        if ($userActifUpdate) {
                            return redirect()->to(base_url('/user/user_confirmation'))->with('success', 'Vos données sont enregistrées et envoyées aux services G-GSCOP avec succès!');
                        }
                    } else {
                        // At least one update failed, redirect with error message
                        return redirect()->to('/user')->with('error', 'Desolé, une erreur est survenue lors de l\'enregistrement de vos données');
                    }
                }
            }
        }
    }

    public function user_confirmation()
    {
        return view('user/user_confirmation');
    }
}
