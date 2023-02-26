<?php

namespace app\Controllers;

use app\Core\Controller;

class HomeController extends Controller
{
  public function index()
  {
    header("HTTP/1.0 200");
    return self::returnJson( array('response' => 'Success') );
  }
}
