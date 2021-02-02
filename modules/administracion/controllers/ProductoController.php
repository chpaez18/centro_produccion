<?php
use Modules\administracion\models\Producto;
use Modules\administracion\models\Materia;
use Modules\administracion\models\ProductoComponente;
use Application\Controller;
use Application\Session;
use Application\Router;
use Application\Utilities;
use AdamWathan\Form\FormBuilder;
use Plasticbrain\FlashMessages\FlashMessages;
use Illuminate\Database\Capsule\Manager as Capsule;


/**
* 
*/
class ProductoController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}

    public function index(){}
	
	
	public function list(){
		$producto = new Producto();
		$form = new FormBuilder();
		$dataProvider = $producto->getProductos();
		//echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>';

		
		if(Session::get("autenticado")){
            
            Session::accesoEstricto(["1"]);

			$this->_view->titulo = "Listado";
			$this->_view->script_propios = 'producto-scripts.js';
			$this->_view->datatable = 'productos-listado';
			
			$this->_view->render("list", "producto",[
				"form"=>$form,
				"dataProvider"=>$dataProvider,
				"producto"=>$producto
			]);

		}else{

			$this->redirect("site/login");
		}
	}

	public function create(){
        $producto = new Producto();
		$form = new FormBuilder();
		$msg = new FlashMessages();
		$materias = new Materia();

		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {
			$model = new Producto ();
			$model->nombre = $_POST["nombre"];
			$model->estatus = $_POST["estatus"];
			$model->save();
			
			foreach ($_POST["id_materia_prima"] as $key => $value) {
				$productoComponente = new ProductoComponente();
				$productoComponente->id_producto = $model->id_producto;
				$productoComponente->id_materia_prima = $_POST["id_materia_prima"][$key];
				$productoComponente->cantidad = $_POST["cantidad"][$key];
				$productoComponente->save();
			}
			
				$msg->sweetAlertMessage(swal2('','Producto Registrado'));
				$msg->success('test',ROUTER::create_action_url("administracion/producto/list"));
			
		}else{

			$this->_view->titulo = "Agregar";
			$this->_view->script_propios = 'producto-scripts.js';
			$this->_view->render("_form", "producto",[
				"form"=>$form,
				"materias"=>$materias
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}



	public function update($id){
		$producto = Producto::find($id);
		$form = new FormBuilder();
		$msg = new FlashMessages();
		$materias = new Materia();
		$componentes = ProductoComponente::whereRaw('id_producto = ? ', [$id])->get()->toArray();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {

			$producto->nombre = $_POST["nombre"];
			$producto->estatus = $_POST["estatus"];
			$producto->save();
			Capsule::select('DELETE FROM productos_componentes WHERE id_producto = '.$id);
			
			foreach ($_POST["id_materia_prima"] as $key => $value) {
				$productoComponente = new ProductoComponente();
				$productoComponente->id_producto = $id;
				$productoComponente->id_materia_prima = $_POST["id_materia_prima"][$key];
				$productoComponente->cantidad = $_POST["cantidad"][$key];
				$productoComponente->save();
			}
			
				$msg->sweetAlertMessage(swal2('','Producto Actualizado'));
				$msg->success('test',ROUTER::create_action_url("administracion/producto/list"));
			
		}else{

			$this->_view->titulo = "Actualizar";
			$this->_view->script_propios = 'producto-scripts.js';
			$this->_view->render("_form", "producto",[
				"form"=>$form,
				"producto"=>$producto,
				"materias"=>$materias,
				"componentes"=>$componentes
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}

	public function delete($id){
		$model = Producto::find($id);
		$msg = new FlashMessages();
		
		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			Capsule::select('DELETE FROM productos_componentes WHERE id_producto = '.$id);
			if($model->delete()){
				$msg->sweetAlertMessage(swal2('','Producto Eliminado'));
				$msg->success('test',ROUTER::create_action_url("administracion/producto/list"));
			}


		}else{

			$this->redirect("site/login");
		}
	}


	public function view($id){
		$producto = Producto::find($id);
		//$componentes = $producto->componentes->toArray();

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			
			$this->_view->titulo = "Detalle";
			$this->_view->script_propios = 'producto-scripts.js';
			$this->_view->render("view", "producto",[
				"producto"=>$producto,
			]);
		}else{

			$this->redirect("site/login");
		}
	}


}

?>