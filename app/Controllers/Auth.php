<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use App\Models\NewUsersModel;
use App\Services\UserService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RedirectResponse;


class Auth extends BaseController
{
    use ResponseTrait;

    protected $required_message = 'Ce champs est obligatoire';
    protected $min_length_message = 'Le mot de passe doit avoir 12 caractères au moins';
    protected $max_length_message = 'Le mot de passe ne doit pas avoir plus de 30 caractères';

    public $data = [];
    // le constructeur
    public function __construct()
    {
        helper(['url', 'form', 'Form_helper.php']);
    }


    // page de login
    public function index(): string
    {
        return view('auth/login');
    }

    // register page
    public function register(): string
    {
        // Load the URI helper
        $uri = service('uri');
        // Get the token from the URL
        $token = $uri->getSegment(4); // Assuming 'token' is the 4th segment in the URI
        // Check if the token is valid
        if ($this->isValidToken($token)) {
            // Token is valid, proceed to registration
            return view('auth/register');
        } else {
            // Token is invalid, redirect to 404 page
            return view('errors/html/error_404');
        }
    }

    // la procedure d'enregistrement
    public function save()
    {
        $validation = $this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => $this->required_message,
                    'valid_email' => 'Cette adresse mail n\'est pas valide',
                    'is_not_unique' => 'Cette adresse mail est n\'exite pas dans notre base'
                ]
            ],
            'password' => [
                'label' => 'Mot de passe',
                'rules' => 'required|min_length[12]|max_length[30]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/]|no_repeating_chars[3]',
                'errors' => [
                    'required' => $this->required_message,
                    'min_length' => $this->min_length_message,
                    'max_length' => $this->max_length_message,
                    'regex_match' => 'Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial (@$!%*?&).',
                    'no_repeating_chars' => 'Le mot de passe ne doit pas contenir trois caractères consécutifs identiques.'
                ]
            ],
            'cfpassword' => [
                'label' => 'Confirmer le mot  de passe',
                'rules' => 'required|min_length[12]|max_length[30]|matches[password]',
                'errors' => [
                    'required' => $this->required_message,
                    'min_length' => $this->min_length_message,
                    'max_length' => $this->max_length_message,
                    'matches' => 'Le mot de passe et la confirmation ne sont pas identiques'
                ]
            ]

        ]);

        if (!$validation) {
            return view('auth/register', ['validation' => $this->validator]);
        } else {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $values = [
                'email' => $email,
                'password' => Hash::make($password)
            ];

            $new_user_model = new NewUsersModel();
            $user = $new_user_model->where('email', $email)->first();
            if (isset($user['password']) && $user['password'] != '') {
                return redirect()->back()->with('fail', 'Vous êtes déjà enregistré dans l\'application <br>
                You are already registered in the app.<br><a href="/auth">Se connecter / Log in</a>');
            }
            $id = $user['id_user'];
            $query = $new_user_model->set($values)->where('id_user', $id)->update();
            if (!$query) {
                return redirect()->back()->with('fail', 'Un problème est survenu lors de l\'enregistrement de vos données');
            } else {
                /**
                 *this redirect user to register page, after he must click on login to provid his information
                 * return redirect()->to('auth/register')->with('success', 'Vous êtes maintenant enregistré.');
                 */
                $new_user_model->update($user['id_user'], ['verified' => true, 'token' => null]);
                return redirect()->to('/auth')->with('success', 'Vous êtes bien enregistré / You are registered successfully now.');
            }
        }
    }

    // Vérifier le mot de passe pour le login
    public function check()
    {
        $validation = $this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => $this->required_message,
                    'valid_email' => 'Cette adresse mail n\'est pas valide',
                    'is_not_unique' => 'Cette adresse mail n\'existe pas / This email address does not exist'
                ]
            ],
            'password' => [
                'label' => 'Mot de passe',
                'rules' => 'required|min_length[12]|max_length[30]',
                'errors' => [
                    'required' => $this->required_message,
                    'min_length' => $this->min_length_message,
                    'max_length' => $this->max_length_message
                ]
            ]
        ]);
        if (!$validation) {
            return view('auth/login', ['validation' => $this->validator]);
        } else {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $user_info = UserService::getUserInfo($email);
            $checked_password = Hash::check($password, $user_info['password']);

            if (!$checked_password) {
                session()->setFlashdata('fail', 'Votre mote de passe est incorrect <br><i>Your password is wrong</i>');
                return redirect()->to('/auth')->withInput();
            } else {
                // tester si le compte utilisateur est verifié ou non
                $verified = $user_info['verified'];
                if ($verified !== 't') {
                    session()->setFlashdata('fail', 'Compte non verifié, contactez le service RH du laboratoire<br>
                    <i>Your account is not verified, please contact the HR to reactivate your account.</i>');
                    return redirect()->to('/auth')->withInput();
                }
                // tester si le compte utilisateur est actif ou non
                $actif = $user_info['actif'];
                if ($actif !== 't') {
                    session()->setFlashdata('fail', 'Votre compte est inactif, veuillez contacter le service RH pour réactiver votre compte.  <br>
                    <i>Your account is inactive, please contact the HR to reactivate your account.</i>');
                    return redirect()->to('/auth')->withInput();
                }
                $role = $user_info['role'];
                $id_logged_user = $user_info['id_user'];
                $statut = $user_info['na_status'];
                $email = $user_info['email'];
                if ($role === 't') {
                    session()->set(['logged_in' => true, 'id_logged_user' => $id_logged_user, 'logged_user' => $user_info["nom"] . ' ' . $user_info["prenom"], 'role' => $role]);
                    return redirect()->to('/comptes');
                } else {
                    session()->set([
                        'logged_in' => true, 'id_logged_user' => $id_logged_user, 'logged_user' => $user_info["nom"] . ' ' . $user_info["prenom"], 'role' => $role, 'statut_logged_user' => $statut,
                        'email_logged_user' => $email
                    ]);
                    return redirect()->to('/user');
                }
            }
        }
    }

    // Déconnexion méthode
    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/auth?access=out')->withInput();
    }

    private function isValidToken($token): bool
    {
        // Load the UserModel or replace with your actual model name
        $userModel = new \App\Models\NewUsersModel();

        // Query the database to check if the token exists
        $user = $userModel->where('token', $token)->first();
        // If a user with the given token is found, return true; otherwise, return false
        return ($user !== null);
    }
}
