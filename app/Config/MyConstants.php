<?php

namespace Config;

class MyConstants
{
    public static function getMessageFrench($link, $operation)
    {
        switch ($operation) {
            case "add":
                return '<p>Bonjour,</p>
                <p>Nous sommes ravis de vous informer que votre arrivée au laboratoire est imminente.</p>
                <p>Avant votre arrivée, veuillez prendre quelques instants pour compléter et soumettre le formulaire en utilisant le lien suivant :' . $link . '</p>
                <p>Une fois sur le site, vous avez la possibilité de créer un compte en utilisant l\'adresse e-mail à laquelle vous avez reçu ce message. Ensuite, connectez-vous au site et complétez le formulaire.</p>
                <p>Merci et à bientôt !</p> <br> <br>';
                break;
            case "update":
                return 'Bonjour,
                Votre compte du site g-scop_nouveaux_arrivants a été réactivé. Vous pouvez désormais vous connecter à nouveau.                    
                Pour vous connecter, rendez-vous sur la page de connexion et saisissez votre adresse e-mail et votre mot de passe.

                Nous vous souhaitons une bonne utilisation de votre compte.                    
                L\'équipe RH';
                break;
        }
        return '<p>Bonjour,</p>...' . $link;
    }

    public static function getMessageEnglish($link, $operation)
    {
        switch ($operation) {
            case "add":
                return '<p>Hello,</p>
                <p>We are pleased to inform you that your arrival at the laboratory is approaching.</p>
                <p>Prior to your arrival, please take a moment to complete and submit the form using the following link:' . $link . '</p>
                <p>After accessing the website, you can create an account using the email address to which you received this message. Then, log in to the site and fill out the form.</p>
                <p>Thank you and see you soon!</p>';
                break;
            case "update":
                return  'Hello,                    
                Your g-scop_nouveaux_arrivants account has been reactivated. You can now log in again.
                To log in, go to the login page and enter your email address and password.
                We wish you a pleasant use of your account.
                The HR team';
                break;
        }
    }

    public static function getMessagereactivation()
    {
        return
            'Bonjour,
                    Votre compte du site g-scop_nouveaux_arrivants a été réactivé. Vous pouvez désormais vous connecter à nouveau.                    
                    Pour vous connecter, rendez-vous sur la page de connexion et saisissez votre adresse e-mail et votre mot de passe.

                    Nous vous souhaitons une bonne utilisation de votre compte.                    
                    L\'équipe RH
                    
                    Hello,                    
                    Your g-scop_nouveaux_arrivants account has been reactivated. You can now log in again.
                    To log in, go to the login page and enter your email address and password.
                    We wish you a pleasant use of your account.
                    The HR team';
    }
}
