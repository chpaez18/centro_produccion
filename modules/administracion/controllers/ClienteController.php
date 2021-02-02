<?php
use Modules\administracion\models\Cliente;
use Application\Controller;
use Application\Session;
use Application\Router;
use Application\Utilities;
use AdamWathan\Form\FormBuilder;
use Plasticbrain\FlashMessages\FlashMessages;


/**
* 
*/
class ClienteController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}

    public function index(){}
	
	
	public function list(){
		$cliente = new Cliente();
		$form = new FormBuilder();
		$dataProvider = $cliente->getClientes();
        
		if(Session::get("autenticado")){
            
            Session::accesoEstricto(["1"]);

			$this->_view->titulo = "Listado";
			$this->_view->script_propios = 'cliente-scripts.js';
			$this->_view->datatable = 'clientes-listado';
			
			$this->_view->render("list", "cliente",[
				"form"=>$form,
				"dataProvider"=>$dataProvider,
				"cliente"=>$cliente
			]);

		}else{

			$this->redirect("site/login");
		}
	}

	public function create(){
		$cliente = new Cliente();
		$form = new FormBuilder();
		$msg = new FlashMessages();

		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {

			$model = new Cliente ($_POST);
			if($model->save()){
				$msg->sweetAlertMessage(swal2('','Cliente Registrado'));
				$msg->success('test',ROUTER::create_action_url("administracion/cliente/list"));
			}
			
		}else{

			$this->_view->titulo = "Agregar";
			$this->_view->script_propios = 'cliente-scripts.js';
			$this->_view->render("_form", "cliente",[
				"form"=>$form
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}



	public function update($id){
		$cliente = Cliente::find($id);
		$form = new FormBuilder();
		$msg = new FlashMessages();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {
			
			$model = Utilities::fillData($cliente, $_POST);

			if($model->save()){
				$msg->sweetAlertMessage(swal2('','Cliente Actualizado'));
				$msg->success('test',ROUTER::create_action_url("administracion/cliente/list"));
			}
			
		}else{

			$this->_view->titulo = "Actualizar";
			$this->_view->script_propios = 'cliente-scripts.js';
			$this->_view->render("_form", "cliente",[
				"form"=>$form,
				"cliente"=>$cliente
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}

	public function delete($id){
		$model = Cliente::find($id);
		$msg = new FlashMessages();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);
			if($model->delete()){
				$msg->sweetAlertMessage(swal2('','Cliente Eliminado'));
				$msg->success('test',ROUTER::create_action_url("administracion/cliente/list"));
			}


		}else{

			$this->redirect("site/login");
		}
	}



	public function view($id){
		$cliente = Cliente::find($id);
		//$componentes = $producto->componentes->toArray();

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			
			$this->_view->titulo = "Detalle";
			$this->_view->script_propios = 'cliente-scripts.js';
			$this->_view->render("view", "cliente",[
				"cliente"=>$cliente,
			]);
		}else{

			$this->redirect("site/login");
		}
	}
}

?>