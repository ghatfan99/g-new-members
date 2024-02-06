<?php

namespace App\Libraries;

class Hash
{

    // Crypter le mot de passe
    public static function make($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);

    }

    // Tester le mot de passe
    public static function check($password, $db_password) 
    {
        if(password_verify($password, $db_password))
        {
            return true;
        } else {
            return false;
        }
    }
}