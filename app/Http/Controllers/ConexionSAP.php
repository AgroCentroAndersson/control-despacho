<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use PhpParser\Node\Stmt\TryCatch;
use Throwable;

class ConexionSAP extends Controller
{
    public $url;
    public $user;
    public $password;
    public $companyDB;

    public $cookie = '';

    private function loginSAP()
    {

        $this->url = env('URL_SAP') . 'Login';
        $this->user = env('USER_SAP');
        $this->password = env('PASSWORD_SAP');
        $this->companyDB = env('DB_DATABASE_SAP');

        $body = '{
            "UserName": "' . $this->user . '",
            "CompanyDB": "' . $this->companyDB . '",
            "Password": "' . $this->password . '"
        }';
        $headers = [
            'Content-Type' => 'application/json',
            'Cookie' => 'B1SESSION=28c7ac18-469c-11ee-8000-bc97e19a07d2; ROUTEID=.node4'
        ];

        $client = new Client([
            'verify' => false
        ]);
        $request = new Psr7Request('POST', $this->url, $headers, $body);
        $res = $client->sendAsync($request)->wait();
        // echo $res->getBody();

        return $res->getBody();
    }

    public function validarLogin()
    {

        if ($this->cookie == '') {

            $datos = $this->loginSAP();

            $datos = json_decode($datos);

            $this->cookie = $datos->SessionId;
        }
    }

    public function insertSAP(string $body, string $typeDocument)
    {
        // return $body;
        try {
            $typeDocument = $typeDocument == 'ORDR' ? 'DeliveryNotes' : 'InventoryTransferRequest';
            $this->url = env('URL_SAP') . $typeDocument;

            $client = new Client([
                'verify' => false
            ]);
            $headers = [
                'Content-Type' => 'application/json',
                'Cookie' => 'B1SESSION=' . $this->cookie . '; ROUTEID=.node4'
            ];
            $request = new Psr7Request('POST', $this->url, $headers, $body);
            $res = $client->sendAsync($request)->wait();
            return $res->getBody();
        } catch (Throwable $th) {
            return response()->json([
                'error' => "Error al insertar en SAP"
            ], 500);
        }
    }
}
