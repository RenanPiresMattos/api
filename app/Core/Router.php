<?php

namespace app\Core;

class Router
{
    private $routes = array();

    public function get($route, $callback)
    {
        $this->addRoute('GET', $route, $callback);
    }

    public function post($route, $callback)
    {
        $this->addRoute('POST', $route, $callback);
    }

    public function put($route, $callback)
    {
        $this->addRoute('PUT', $route, $callback);
    }

    public function delete($route, $callback)
    {
        $this->addRoute('DELETE', $route, $callback);
    }

    private function addRoute($method, $route, $callback)
    {
        $route = preg_replace('/\{(\w+)\}/', '(\w+)', $route);
        $route = "#^$route$#";
        $this->routes[$method][$route] = array('callback' => $callback);
    }

    public function route()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($method, $this->routes)) {
            foreach ($this->routes[$method] as $route => $data) {
                if (preg_match($route, $uri, $matches)) {

                    array_shift($matches);
                    $callback = $data['callback'];
                    $class = new $callback[0];
                    call_user_func_array([$class, $callback[1]], $matches);
                    return;
                }
            }
            header("HTTP/1.0 404");
            $array['mensagem'] = "Not found.";
            echo json_encode($array);
        } else {
            header("HTTP/1.0 405");
            $array['mensagem'] = "Method not allowed.";
            echo json_encode($array);
        }
    }
}
