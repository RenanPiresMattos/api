<?php

namespace app\Core;

class Request
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

}
