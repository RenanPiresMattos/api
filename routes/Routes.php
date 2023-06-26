<?php
namespace routes;

use app\Controllers\AuthController;
use app\Core\Router;
use app\Controllers\HomeController;

class Routes {

    public function api(){

        $router = new Router();    
        //HOME
        $router->get('/', [HomeController::class, 'index']);
        $router->post('/login', [AuthController::class, 'login']);
    
        $router->route();
    
    }    
}







