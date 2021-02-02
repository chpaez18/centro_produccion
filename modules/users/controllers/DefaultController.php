<?php
use Modules\users\models\Users;
use Application\Controller;
use Application\Session;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
/**
* 
*/
class DefaultController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}


	public function index(){
		$users = new Users();
		if(Session::get("autenticado")){
					
			$this->_view->titulo = "Users";
			$this->_view->render("index", "default");

		}else{

			$this->redirect("site/login");
		}
	}	
}

?>