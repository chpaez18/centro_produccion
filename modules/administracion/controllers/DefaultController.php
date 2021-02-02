<?php
use Modules\dashboard\models\Dashboard;
use Application\Controller;
use Application\Session;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;
use AdamWathan\Form\FormBuilder;


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
		$dashboard = new Dashboard();
		$builder = new FormBuilder();
		if(Session::get("autenticado")){

		if (!empty($_POST)) {
			$model = new Dashboard ($_POST);
			var_dump($model);
		}else{
			$this->_view->titulo = "Dashboard";
			$this->_view->render("index", "default",["builder"=>$builder]);
		}

		}else{

			$this->redirect("site/login");
		}
	}	
}

?>