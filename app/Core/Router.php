<?php
namespace app\Core;

use app\Middleware\JWT;
use Exception;

class Router {
    private $routes = array();

    public function get($route, $callback, $protected = false) {
        $this->addRoute('GET', $route, $callback, $protected);
    }

    public function post($route, $callback, $protected = false) {
        $this->addRoute('POST', $route, $callback, $protected);
    }

    public function put($route, $callback, $protected = false) {
        $this->addRoute('PUT', $route, $callback, $protected);
    }

    public function delete($route, $callback, $protected = false) {
        $this->addRoute('DELETE', $route, $callback, $protected);
    }

    private function addRoute($method, $route, $callback, $protected) {
        $route = preg_replace('/\{(\w+)\}/', '(\w+)', $route);
        $route = "#^$route$#";
        $this->routes[$method][$route] = array('callback' => $callback, 'protected' => $protected);
    }

    public function route() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
    
        if (array_key_exists($method, $this->routes)) { 
            foreach ($this->routes[$method] as $route => $data) {
                if (preg_match($route, $uri, $matches)) {
                    if ($data['protected']) {
                        $headers = apache_request_headers();
                        
                        if (!isset($headers['Authorization'])) {
                            header("HTTP/1.0 401");
                            $array['response'] = "Token not sent.";
                            echo json_encode($array);
                            return;
                        } else {
                            $token = explode(' ', $headers['Authorization'])[1];
                            try {
                                $jwt = new JWT(trim(getenv('TOKEN_KEY')));
                                $decoded = $jwt->decode($token);
                                if($decoded != true){
                                   throw new Exception($decoded);
                                }
                                array_shift($matches);
                                $callback = $data['callback'];
                                $class = new $callback[0];
                                call_user_func_array([$class, $callback[1]], $matches);
                                return;
                            } catch (Exception $e) {
                                header("HTTP/1.0 401");
                                $array['response'] = $e->getMessage();
                                echo json_encode($array);
                                return;
                            }
                        }
                    } else {
                        array_shift($matches);
                        $callback = $data['callback']; 
                        $class = new $callback[0];
                        call_user_func_array([$class, $callback[1]], $matches);
                        return;
                    }
                }
            }
            header("HTTP/1.0 404");
            $array['response'] = "Not found.";
            echo json_encode($array);
        } else {
            header("HTTP/1.0 405");
            $array['response'] = "Method not allowed.";
            echo json_encode($array);
        }
    }
}