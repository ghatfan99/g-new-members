<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\App;



class BaseModel extends Model
{

    private $url_silose = null;
    private $api_key = null;


    /**
     * __construct
     * constructor
     *
     * @return void
     */
    function __construct()
    {
        parent::__construct();

        $app = new App();
        if (strlen(trim($app->urlSiloseBackend)) > 0) {
            $chaine = trim($app->urlSiloseBackend); //change on production environment on app config file
            $id_lastchar = strlen($chaine) - 1;
            $this->url_silose = ($chaine[$id_lastchar] == '/') ?  substr($chaine, 0, $id_lastchar) : $chaine;
        }
        if (strlen(trim($app->api_key)) > 0) {
            $this->api_key = $app->api_key;
        }
    }

    /**
     * getSiloseUrl
     *
     * @return string
     */
    protected function getSiloseUrl()
    {
        return $this->url_silose;
    }

    /**
     * setApiKey
     *
     * @param string $api_key
     * @return void
     */
    protected function setApiKey(string $api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * getApiKey
     *
     * @return string
     */
    protected function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * getDataCURL
     *
     * @param  mixed $url
     * @return mixed
     */
    protected function getDataCURL($url)
    {
        log_message('debug', 'getDataCURL ' . $url);
        //***** CURL *****/
        $api_key = $this->getApiKey();

        // create curl resource
        $ch = curl_init();
        // set url       
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-API-Key: ' . $api_key));
        // FALSE for don't do not check the certificate
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $output contains the output string
        $output = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch);
        return $output;
    }

    /**
     * checkInStringIsJsonArray
     *
     * @param  mixed $string
     * @return mixed
     */
    protected function checkInStringIsJsonArray(&$string)
    {
        return checkStringIsJsonArray($string); //helper
    }

    /**
     * checkInStringIsJsonArray
     *
     * @param  mixed &$string
     * @return mixed reference
     */
    protected function &convertInStringIsJsonArray(&$string)
    {
        return convertStringInJsonArray($string); //helper
    }
}
