<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiCreateDocument extends Controller
{
    private $_urlSAP;
    private $_tokenSAP;
    private $_cookieSAP;
    private $_jsonSAP;

    private function _loginSAP(){

        $this->_urlSAP = env('URL_SAP', 'https://192.168.1.9:50000/b1s/v1/').'Login';
        $this->_jsonSAP = '{
                                "UserName": "'.env('USER_SAP', 'manager').'",
                                "CompanyDB": "'.env('DB_DATABASE_SAP', 'T_GT_AGROCENTRO_2016_U').'",
                                "Password": "'.env('PASSWORD_SAP', 'Team64110').'"
                            }';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_urlSAP,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$this->_jsonSAP,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

        $response = json_decode($response, true);
        return $response;

    }
    public function createDocumentSAP(Request $request){

        $response = $this->_loginSAP();

        return $response;

    }
}
