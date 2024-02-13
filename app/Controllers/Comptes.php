<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NewUsersModel;

use CodeIgniter\API\ResponseTrait;

class Comptes extends BaseController
{
    use ResponseTrait;

    protected $required_message = 'Ce champs est obligatoire';
    protected $min_length_message = 'Le mot de passe doit avoir 12 caractères au moins';

    protected $new_user_model;

    public $data = [];
    // le constructeur
    public function __construct()
    {
        if (session()->get('role' != 't')) {
            echo "Vous n'avez pas acces à la page demandée";
        } else {
            helper(['url', 'form', 'Form_helper.php', 'Email_helper.php']);
            $this->new_user_model = new NewUsersModel();
            $logged_user_id = session()->get('id_logged_user');

            $user_info = $this->new_user_model->where('id_user', $logged_user_id)->first();
            $comptes = $this->new_user_model->orderBy('id_user', 'DESC')->findAll();
            // Define the status mapping
            $statusMapping = [
                'gestionrh' => 'Gestionnaire Administratif',
                'phd' => 'Doctorant / Phd',
                'ipostdoc' => 'Post-doc / Ingénieur',
                'autres' => 'Autres (Stagiaire, Invité, ...)',
                'chercheurEc' => 'Chercheur, EC',
            ];

            // Modify the 'na_status' in each $elt based on the mapping
            foreach ($comptes as &$elt) {
                $elt['na_status'] = $statusMapping[$elt['na_status']] ?? $elt['na_status'];
            }
            // ******************* //
            $this->data['user_info'] = $user_info;
            $this->data['comptes'] = $comptes;
        }
    }

    /**
     * Partie gestion de comptes
     * Ajout d'un compte
     * Mettre à jour un compte
     * Affichier tous les comptes
     */
    public function comptes(): string
    {
        $this->data['pageTitle'] = 'Liste de comptes';
        return view('comptes/comptes', $this->data);
    }

    //**************************************************/
    //**************************************************/

    // function pour sauvegarder un compte utlisateur
    public function save_compte()
    {
        $validation = \Config\Services::validation();
        // set the validation rules 
        $validation->setRules($this->new_user_model->validationRules);

        if (!$validation->run($this->request->getPost())) {
            // echo ("false validation !!!!");
            // exit;
            $data["validation"] = $validation;
            $data["comptes"] = $this->data["comptes"];
            $data["pageTitle"] = 'Nouveau compte';
            $data["user_info"] = $this->data['user_info'];

            return view('comptes/create_compte', $data);
        } else {
            $nom = securestring($this->request->getPost('nom'));
            $prenom = securestring($this->request->getPost('prenom'));
            $email = securestring($this->request->getPost('email'));
            $actif = isset($_POST['actif']) && $this->request->getPost('actif') !== '' ? 't' : 'f';
            $role = isset($_POST['admin']) && $this->request->getPost('admin') !== '' ? 't' : 'f';
            $na_status = securestring($this->request->getPost('statutOptions'));
            // créer un token
            $randomBytes = random_bytes(32);
            $token = bin2hex($randomBytes);
            // **************************************
            $values = [
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'role' => $role,
                'actif' => $actif,
                'na_status' => $na_status,
                'token' => $token
            ];

            // $new_user_model = new NewUsersModel();
            var_dump($values);
            exit;
            $query = $this->new_user_model->insert($values);
            if (!$query) {
                return redirect()->back()->with('fail', 'Un problème est survenu lors de l\'enregistrement de vos données');
            } else {
                $url = site_url() . 'auth/register/token/' . $token;
                $link = '<a href="' . $url . '">Gscop-new-arrivals</a>';
                $email = \Config\Services::email();
                // Set recipient info
                $email->setTo('hazem.hasan@grenoble-inp.fr');

                // Set email subject and message
                $email->setSubject('Subject of the Email');
                $messageFrench = '
                    <p>Bonjour,</p>
                    <p>Nous sommes ravis de vous informer que votre arrivée au laboratoire est imminente.</p>
                    <p>Avant votre arrivée, veuillez prendre quelques instants pour compléter et soumettre le formulaire en utilisant le lien suivant :' . $link . '</p>
                    <p>Une fois sur le site, vous avez la possibilité de créer un compte en utilisant l\'adresse e-mail à laquelle vous avez reçu ce message. Ensuite, connectez-vous au site et complétez le formulaire.</p>
                    <p>Merci et à bientôt !</p> <br> <br>';
                $messageEnglish = '<p>Hello,</p>
                    <p>We are pleased to inform you that your arrival at the laboratory is approaching.</p>
                    <p>Prior to your arrival, please take a moment to complete and submit the form using the following link:' . $link . '</p>
                    <p>After accessing the website, you can create an account using the email address to which you received this message. Then, log in to the site and fill out the form.</p>
                    <p>Thank you and see you soon!</p>';
                $email = send_email('hazem.hasan@grenoble-inp.fr', 'Votre arrivé au laboratoire G-SCOP', $messageFrench . $messageEnglish);
                try {
                    if ($email) {
                        /**
                         * pour diriger l'admine vers la page qui affiche les utilisateurs
                         */
                        return redirect()->to('/comptes')->with('success', 'Le nouveau compte a été crée avec succès.');
                    } else {
                        echo 'Email sending failed!';
                    }
                } catch (\Exception $e) {
                    echo 'Error: ' . $e->getMessage();
                }
            }
        }
    }

    // function pour mettre à jour un compte utlisateur
    public function update_compte($id_user)
    {
        $compte = new NewUsersModel();
        // trouver si l'utilisateur es actif où non
        $userActif = $compte->select('actif')->where('id_user', $id_user)->first();
        $actifVal = isset($_POST['actif']) ? $_POST['actif'] : null;
        $compteReActive = ($userActif['actif'] === 'f' || $userActif['actif'] === null) && ($actifVal === 'on');
        // ************************************************************************
        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email' => $this->request->getPost('email'),
            'actif' => isset($_POST['actif']) && $this->request->getPost('actif') !== '' ? 't' : 'f',
            'role' => isset($_POST['admin']) && $this->request->getPost('admin') !== '' ? 't' : 'f',
            'na_status' => $this->request->getPost('statutOptions'),
            'id_user' => $id_user
        ];

        $validation = $this->validate([
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
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => $this->required_message,
                    'valid_email' => 'Cette adresse mail n\'est pas valide'
                ]
            ],
            'statutOptions' => [
                'label' => 'Statut',
                'rules' => 'required',
                'errors' => [
                    'required' => $this->required_message
                ]
            ]
        ]);

        if (!$validation) {
            $data["validation"] = $this->validator;
            $data["pageTitle"] = 'Mettre à jour un compte';
            $data["user_info"] = $data;

            return view('comptes/edit_compte', $data);
        } else {
            $result = $compte->set($data)->where('id_user', $id_user)->update();
            if ($result == true) {
                if ($compteReActive) {
                    $email = \Config\Services::email();
                    // Set recipient info
                    // $email->setTo('hazem.hasan@grenoble-inp.fr');
                    $email->setTo('gscop.work@gmail.com');

                    // Set email subject and message
                    $email->setSubject('Réactivation de votre compte / Your account has been reactivated');
                    $email->setMessage('Bonjour,
                    Votre compte du site g-scop_nouveaux_arrivants a été réactivé. Vous pouvez désormais vous connecter à nouveau.                    
                    Pour vous connecter, rendez-vous sur la page de connexion et saisissez votre adresse e-mail et votre mot de passe.

                    Nous vous souhaitons une bonne utilisation de votre compte.                    
                    L\'équipe RH
                    
                    Hello,                    
                    Your g-scop_nouveaux_arrivants account has been reactivated. You can now log in again.
                    To log in, go to the login page and enter your email address and password.
                    We wish you a pleasant use of your account.
                    The HR team');
                    try {
                        if ($email->send()) {
                            /**
                             *this redirect user to register page, after he must click on login to provid his information
                             * return redirect()->to('auth/register')->with('success', 'Vous êtes maintenant enregistré.');
                             */

                            /**
                             * pour diriger l'admin vers la page qui affiche les utilisateurs
                             */
                            return redirect()->to('/comptes')->with('success', 'Le compte a été mise à jours avec succès.');
                        } else {
                            echo 'Email sending failed!';
                        }
                    } catch (\Exception $e) {
                        echo 'Error: ' . $e->getMessage();
                    }
                }
                session()->setFlashData("success", "Compte modifié avec succès");
                return redirect()->to('/comptes')->with('success', 'Le compte a été mise à jours avec succès.');
            } else {
                session()->setFlashData("error", "Erreur lors de la modification du compte");
            }
        }
    }
    // Supprimer une compte utilisateur    
    public function delete_compte()
    {
        $NewUsersModel = new NewUsersModel();
        $id = $this->request->getPost('id_user');
        var_dump($_POST);
        $data['user'] = $NewUsersModel->where('id_user', $id)->delete();
        return redirect()->to('/comptes')->with('success', 'L\'utilisateur a été bien supprimé.');
    }
    // Créer ou modifier un compte utilisateur
    public function createOrUpdateCompte($id_user = null)
    {
        $data = [];
        if ($id_user) {

            $compte = new NewUsersModel();
            $data['user_info'] = $compte->where('id_user', $id_user)->first();
            $data['operation'] = 'update';

            // echo "update method " . $id_user;
            $data['pageTitle'] = 'Mise à jour du compte';
        } else {
            $data['pageTitle'] = 'Nouveau compte';
            $data['operation'] = 'create';
        }
        $view = 'comptes/create_update_compte';
        // Render the view with data
        return view($view, $data);
    }

    public function save_update_compte($id_user = null)
    {
        // Your common validation rules
        $validationRules = [
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
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email' . ($id_user ? '' : '|is_unique[users.email]'), // Check uniqueness only for new users
                'errors' => [
                    'required' => $this->required_message,
                    'valid_email' => 'Cette adresse mail n\'est pas valide',
                    'is_unique' => 'Cette adresse mail est déjà utilisée'
                ]
            ],
            'dateDebut' => [
                'label' => 'Date début',
                'rules' => 'required',
                'errors' => [
                    'required' => $this->required_message
                ]
            ],
            'dateFin' => [
                'label' => 'Date fin',
                'rules' => 'required',
                'errors' => [
                    'required' => $this->required_message
                ]
            ],
            'statutOptions' => [
                'label' => 'Statut',
                'rules' => 'required',
                'errors' => [
                    'required' => $this->required_message
                ]
            ]
        ];

        $validation = $this->validate($validationRules);
        if ($validation) {
            // If validation passes, proceed with data handling
            $compteModel = new NewUsersModel();
            // créer un token
            $randomBytes = random_bytes(32);
            $token = bin2hex($randomBytes);

            // Prepare data array
            $data = [
                'nom' => $this->request->getPost('nom'),
                'prenom' => $this->request->getPost('prenom'),
                'email' => $this->request->getPost('email'),
                'date_debut' => $this->request->getPost('dateDebut'),
                'date_fin' => $this->request->getPost('dateFin'),
                'role' => isset($_POST['admin']) && $this->request->getPost('admin') !== '' ? 't' : 'f',
                'actif' => isset($_POST['actif']) && $this->request->getPost('actif') !== '' ? 't' : 'f',
                'na_status' => $this->request->getPost('statutOptions'),
                'token' => $token
            ];
            // Data specific to update
            if ($id_user) {
                $data['id_user'] = $id_user;
                $result = $compteModel->set($data)->where('id_user', $id_user)->update();
                $redirectMessage = 'Le compte a été mis à jour avec succès.';
            } else {
                $result = $compteModel->insert($data);
                $redirectMessage = 'Le nouveau compte a été créé avec succès.';
            }
            if ($result == true) {
                // Send email logic here
                $url = site_url() . 'auth/register/token/' . $token;
                $link = '<a href="' . $url . '">Gscop-new-arrivals</a>';
                $email = \Config\Services::email();
                // Set recipient info
                $email->setTo('hazem.hasan@grenoble-inp.fr');

                // Set email subject and message
                $email->setSubject('Subject of the Email');
                $messageFrench = '
                    <p>Bonjour,</p>
                    <p>Nous sommes ravis de vous informer que votre arrivée au laboratoire est imminente.</p>
                    <p>Avant votre arrivée, veuillez prendre quelques instants pour compléter et soumettre le formulaire en utilisant le lien suivant :' . $link . '</p>
                    <p>Une fois sur le site, vous avez la possibilité de créer un compte en utilisant l\'adresse e-mail à laquelle vous avez reçu ce message. Ensuite, connectez-vous au site et complétez le formulaire.</p>
                    <p>Merci et à bientôt !</p> <br> <br>';
                $messageEnglish = '<p>Hello,</p>
                    <p>We are pleased to inform you that your arrival at the laboratory is approaching.</p>
                    <p>Prior to your arrival, please take a moment to complete and submit the form using the following link:' . $link . '</p>
                    <p>After accessing the website, you can create an account using the email address to which you received this message. Then, log in to the site and fill out the form.</p>
                    <p>Thank you and see you soon!</p>';
                $email = send_email('hazem.hasan@grenoble-inp.fr', 'Votre arrivé au laboratoire G-SCOP', $messageFrench . $messageEnglish);
                try {
                    if ($email) {
                        /**
                         * pour diriger l'admine vers la page qui affiche les utilisateurs
                         */
                        return redirect()->to('/comptes')->with('success', 'Le nouveau compte a été crée avec succès.');
                    } else {
                        echo 'Email sending failed!';
                    }
                } catch (\Exception $e) {
                    echo 'Error: ' . $e->getMessage();
                }

                // Redirect to appropriate page
                return redirect()->to('/comptes')->with('success', $redirectMessage);
            } else {
                return redirect()->back()->withInput()->with('error', 'Erreur lors de la sauvegarde ou de la mise à jour du compte.');
            }
        } else {
            echo "Validation fails, id_user = " . $id_user;
            // If validation fails, load the view with validation errors
            $data['validation'] = $this->validator;
            $data['comptes'] = $this->data['comptes'];
            $data['pageTitle'] = $id_user ? 'Mettre à jour un compte' : 'Nouveau compte';
            $data['user_info'] = $this->data['user_info'];

            // Choose the view
            $view = 'comptes/create_update_compte';

            // Render the view with data
            return view($view, $data);
        }
    }
}
