## PHP Version 8.1  ##


To define that the route needs authentication, just pass the last parameter as true, following the example below:

    $router->get('/home', [HomeController::class, 'index'], true);


To pass values ​​in the routes, we indicate as in the example:

    $router->get('/home/{id}', [HomeController::class, 'index']);


Then we receive this parameter in the controller method:

    public function index($id)
    {
    }


