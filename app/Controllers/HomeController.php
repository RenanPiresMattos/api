<?php

namespace app\Controllers;

use app\Core\Controller;
use app\Services\AuthService;

class HomeController extends Controller
{

  public function index()
  {

    $this->checkAuth();

    header("HTTP/1.0 200");
    return self::returnJson( array('response' => 'Success') );
  }
}
