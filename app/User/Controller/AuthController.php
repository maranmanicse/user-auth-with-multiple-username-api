<?php

namespace App\User\Controller;

use App\User;
use Exception;
use App\Http\Controllers\Controller;
use App\User\Service\AuthService;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    protected $serv;

    public function __construct(AuthService $serv)
    {
        $this->serv = $serv;
    }
    

    public function register(Request $request)
    {
        $response = $this->serv->register($request->all());
        return $response;
    }

    public function getAuthUser(){
        $response = $this->serv->getAuthUser();
        return $response;
    }

    public function login(Request $request)
    {
        $response = $this->serv->login($request->all());
        return $response;
    }

    
    public function logout()
    {
        $response = $this->serv->logout();
        return $response;
       
    }
}
