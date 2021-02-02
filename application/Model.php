<?php 
namespace Models;
use Models\Database;
//clase de la cual extenderan todos nuestros modelos


/**
* 
*/

class Model
{
	
	protected $db;

	public function __construct(){

		$this->db = new Database();

	}
	
}



?>