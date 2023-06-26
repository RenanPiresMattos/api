<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Services\TokenService;

class AuthController extends Controller
{
    public function login()
    {
        $data = $this->getRequestData();

        $jwt = TokenService::generateToken(360, ['cpf' => $data['cpf'], 'senha' => $data['senha']]);

        header("HTTP/1.0 200");
        return self::returnJson( array('response' => 'Success', 'token' => $jwt) );
    }
}