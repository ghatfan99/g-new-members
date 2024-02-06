<?php

namespace App\Services;

use App\Models\AllUsersModel;
use App\Models\NewUsersModel;
use App\Models\PhdUserModel;
use App\Models\IpostdocUserModel;
use App\Models\AutresUserModel;
use App\Models\EcUserModel;
use App\Models\SrvInfoUserModel;

class UserService
{
    /**
     * Les informations qui concernet tout les utilistaeurs
     */
    public static function getUserSharedInfo($id_user)
    {
        $allUsersModel = new AllUsersModel();
        $user_shared_info = $allUsersModel->where('id_user', $id_user)->first();
        return $user_shared_info ? $user_shared_info : [];
    }

    /**
     * Les information des comptes utilistaeurs
     */
    public static function getUserInfo($email)
    {
        $new_user_model = new NewUsersModel();
        $user = $new_user_model->where('email', $email)->first();
        return $user ? $user : [];
    }

    /**
     * Les information suplementaires selon le statut de la personne
     */
    public static function getUserInfoStatut($id_user, $status)
    {
        switch ($status) {
            case 'phd':
                $phdUserModel = new PhdUserModel();
                $phdUserInfo = $phdUserModel->where('id_user', $id_user)->first();
                return $phdUserInfo ? $phdUserInfo : [];
            case 'ipostdoc':
                $ipUserModel = new IpostdocUserModel();
                $ipUserInfo = $ipUserModel->where('id_user', $id_user)->first();
                return $ipUserInfo ? $ipUserInfo : [];
            case 'autres':
                $autresUserModel = new AutresUserModel();
                $autreUserInfo = $autresUserModel->where('id_user', $id_user)->first();
                return $autreUserInfo ? $autreUserInfo : [];
            case 'chercheurEc':
                $chercheurEcUserModel = new EcUserModel();
                $chercheurEcUserInfo =  $chercheurEcUserModel->where('id_user', $id_user)->first();
                return $chercheurEcUserInfo ? $chercheurEcUserInfo : [];
            default:
                return [];
        }
    }

    /**
     * Les information qui concernent le service informatique
     */
    public static function getUserInfoSrvInfo($id_user)
    {
        $srvUserInfoModel  = new SrvInfoUserModel();
        $srvUserInfo = $srvUserInfoModel->where('id_user', $id_user)->first();
        return $srvUserInfo ? $srvUserInfo : [];
    }
}
