<?php

namespace app\Core;

use app\Services\AuthService;
use Exception;

class Controller
{

	public function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function getRequestData()
	{

		switch (self::getMethod()) {
			case 'GET':
				return $_GET;
				break;

			case 'PUT':

				$data = json_decode(file_get_contents('php://input'));
				if (is_null($data)) {
					$data = $_POST;
				}

				return (array) $data;
				break;

			case 'DELETE':
				parse_str(file_get_contents('php://input'), $data);
				return (array) $data;
				break;
			case 'POST':

				$data = json_decode(file_get_contents('php://input'));
				if (is_null($data)) {
					$data = $_POST;
				}

				return (array) $data;
				break;
		}
	}

	public function checkAuth()
	{
		try{
			AuthService::verifyToken();
		}catch(Exception $e){
			header("HTTP/1.0 401");
			return self::returnJson( array('response' => $e->getMessage()) );
		}
	}

	public function returnJson($array)
	{
		header("Content-Type: application/json");
		echo json_encode($array);
		exit;
	}

}
