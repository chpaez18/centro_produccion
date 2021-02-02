<?php
use Modules\administracion\models\Inventario;
use Modules\administracion\models\Almacen;
use Modules\administracion\models\Producto;
use Modules\administracion\models\Materia;
use Application\Controller;
use Application\Session;
use Application\Router;
use Application\Utilities;
use AdamWathan\Form\FormBuilder;
use Plasticbrain\FlashMessages\FlashMessages;


/**
* 
*/
class InventarioController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}

    public function index(){}
	
	
	public function list(){
		$inventario = new Inventario();
		$form = new FormBuilder();
		$dataProvider = $inventario->getInventarios();
		

		if(Session::get("autenticado")){
            
            Session::accesoEstricto(["1"]);

			$this->_view->titulo = "Listado";
			$this->_view->script_propios = 'inventario-scripts.js';
			$this->_view->datatable = 'inventario-listado';
			
			$this->_view->render("list", "inventario",[
				"form"=>$form,
				"dataProvider"=>$dataProvider,
				"inventario"=>$inventario
			]);

		}else{

			$this->redirect("site/login");
		}
	}

	public function create(){
        $inventario = new Inventario();
		$form = new FormBuilder();
		$msg = new FlashMessages();
		$productos = new Producto();
		$almacenes = new Almacen();
		$materias = new Materia();
		$productos = $productos->getProductos();
		$materias = $materias->getMaterias();

		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {

			$model = new Inventario ($_POST);

			if($model->save()){
				$msg->sweetAlertMessage(swal2('','Inventario Registrado'));
				$msg->success('test',ROUTER::create_action_url("administracion/inventario/list"));
			}
			
		}else{

			$this->_view->titulo = "Agregar";
			$this->_view->script_propios = 'inventario-scripts.js';
			$this->_view->render("_form", "inventario",[
				"form"=>$form,
				"productos"=>$productos,
				"almacenes"=>$almacenes,
				"materias"=>$materias
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}



	public function update($id){
		$inventario = Inventario::find($id);
		$form = new FormBuilder();
		$msg = new FlashMessages();
		$productos = new Producto();
		$almacenes = new Almacen();
		$materias = new Materia();
		$productos = $productos->getProductos();
		$materias = $materias->getMaterias();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {
			
			if(isset($_POST["id_materia_prima"])){
				$_POST["id_producto"] = null;
			}else{
				$_POST["id_materia_prima"] = null;
			}
			$model = Utilities::fillData($inventario, $_POST);
			
			if($model->save()){
				$msg->sweetAlertMessage(swal2('','Inventario Actualizado'));
				$msg->success('test',ROUTER::create_action_url("administracion/inventario/list"));
			}
			
		}else{

			$this->_view->titulo = "Actualizar";
			$this->_view->script_propios = 'inventario-scripts.js';
			$this->_view->render("_form", "inventario",[
				"form"=>$form,
				"inventario"=>$inventario,
				"productos"=>$productos,
				"almacenes"=>$almacenes,
				"materias"=>$materias
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}

	public function delete($id){
		$model = Inventario::find($id);
		$msg = new FlashMessages();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);
			if($model->delete()){
				$msg->sweetAlertMessage(swal2('','Inventario Eliminado'));
				$msg->success('test',ROUTER::create_action_url("administracion/inventario/list"));
			}


		}else{

			$this->redirect("site/login");
		}
	}


	public function view($id){
		$inventario = Inventario::find($id);
		//$componentes = $producto->componentes->toArray();

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			
			$this->_view->titulo = "Detalle";
			$this->_view->script_propios = 'inventario-scripts.js';
			$this->_view->render("view", "inventario",[
				"inventario"=>$inventario,
			]);
		}else{

			$this->redirect("site/login");
		}
	}
}

?>