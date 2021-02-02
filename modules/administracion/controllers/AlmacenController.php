<?php
use Modules\administracion\models\Almacen;
use Application\Controller;
use Application\Session;
use Application\Router;
use Application\Utilities;
use AdamWathan\Form\FormBuilder;
use Plasticbrain\FlashMessages\FlashMessages;


/**
* 
*/
class AlmacenController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}

    public function index(){}
	
	
	public function list(){
		$almacen = new Almacen();
		$form = new FormBuilder();
		$dataProvider = $almacen->getAlmacenes();
		
		if(Session::get("autenticado")){
            
            Session::accesoEstricto(["1"]);

			$this->_view->titulo = "Listado";
			$this->_view->script_propios = 'almacen-scripts.js';
			$this->_view->datatable = 'almacenes-listado';
			
			$this->_view->render("list", "almacen",[
				"form"=>$form,
				"dataProvider"=>$dataProvider,
				"almacen"=>$almacen
			]);

		}else{

			$this->redirect("site/login");
		}
	}

	public function create(){
        $almacen = new Almacen();
		$form = new FormBuilder();
		$msg = new FlashMessages();

		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {

			$model = new Almacen ($_POST);
			if($model->save()){
				$msg->sweetAlertMessage(swal2('','Almacen Registrado'));
				$msg->success('test',ROUTER::create_action_url("administracion/almacen/list"));
			}
			
		}else{

			$this->_view->titulo = "Agregar";
			$this->_view->script_propios = 'almacen-scripts.js';
			$this->_view->render("_form", "almacen",[
				"form"=>$form
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}



	public function update($id){
		$almacen = Almacen::find($id);
		$form = new FormBuilder();
		$msg = new FlashMessages();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {
			
			$model = Utilities::fillData($almacen, $_POST);

			if($model->save()){
				$msg->sweetAlertMessage(swal2('','Almacen Actualizado'));
				$msg->success('test',ROUTER::create_action_url("administracion/almacen/list"));
			}
			
		}else{

			$this->_view->titulo = "Actualizar";
			$this->_view->script_propios = 'almacen-scripts.js';
			$this->_view->render("_form", "almacen",[
				"form"=>$form,
				"almacen"=>$almacen
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}

	public function delete($id){
		$model = Almacen::find($id);
		$msg = new FlashMessages();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);
			if($model->delete()){
				$msg->sweetAlertMessage(swal2('','Almacen Eliminado'));
				$msg->success('test',ROUTER::create_action_url("administracion/almacen/list"));
			}


		}else{

			$this->redirect("site/login");
		}
	}
}

?>