<?php
namespace routes;

use app\Core\Router;
use app\Controllers\HomeController;

class Routes {

    public function api(){

        $router = new Router();
    
        //HOME
        $router->get('/home', [HomeController::class, 'index']);
    
        $router->route();
    
    }    
}







