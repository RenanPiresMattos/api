<?php
namespace app\Core;

use config\Database;

class Model {

	protected $db;
    public $table;

	public function __construct() {

		$database = new Database();
		$this->db = $database->getConnection();
	}

    public function get(int $id, array $attributes=null)
    {
        $atts= ($attributes)?implode(', ', $attributes):'*';
        $result = $this->db->prepare('select '.$atts.' from '.$this->table. ' where id=:id');
        $result->execute(['id'=>$id]);
        return $result->fetch();
    }

    public function get_all(int $id, array $attributes=null)
    {
        $atts= ($attributes)?implode(', ', $attributes):'*';
        $result = $this->db->prepare('select '.$atts.' from '.$this->table. ' where id=:id');
        $result->execute(['id'=>$id]);
        return $result->fetchAll();
    }

    public function all(array $attributes=null)
    {
        $atts= ($attributes)?implode(', ', $attributes):'*';
        $result = $this->db->prepare('select '.$atts.' from '.$this->table);
        $result->execute();
        return $result->fetchAll();
    }
}  
