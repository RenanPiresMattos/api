<?php

namespace app\Core;

class Controller
{

	public function returnJson($array)
	{
		header("Content-Type: application/json");
		echo json_encode($array);
		exit;
	}

}
