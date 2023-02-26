<?php
namespace app\Core;

use config\Database;

class Model {

	protected $db;

	public function __construct() {

		$database = new Database();
		$this->db = $database->getConnection();
	}
}  
