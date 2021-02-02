<?php
use Modules\solicitudes\models\SolicitudCliente;
use Modules\solicitudes\models\SolicitudClienteItems;
use Modules\administracion\models\Cliente;
use Modules\administracion\models\Producto;
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
class DefaultController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}

	public function index(){}

	public function list(){
		$solicitudes = new SolicitudCliente();
		$form = new FormBuilder();
		$dataProvider = $solicitudes->getSolicitudesClientes();
		
		if(Session::get("autenticado")){
            
            Session::accesoEstricto(["1"]);

			$this->_view->titulo = "Listado";
			$this->_view->script_propios = 'solicitud-scripts.js';
			$this->_view->datatable = 'solicitudes-listado';
			
			$this->_view->render("list", "default",[
				"form"=>$form,
				"dataProvider"=>$dataProvider,
				"solicitudes"=>$solicitudes
			]);

		}else{

			$this->redirect("site/login");
		}
	}

	public function create(){
        $solicitudes = new SolicitudCliente();
		$form = new FormBuilder();
		$msg = new FlashMessages();
		$clientes = new Cliente();
		$productos = new Producto();

		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {

			$model = new SolicitudCliente ();
			$model->id_cliente = $_POST["id_cliente"];
			$model->fecha_registro = $_POST["fecha_registro"];
			$model->observacion = $_POST["observacion"];
			$model->estatus = 0;  //DISEÑAR FUNCION PARA MANEJAR LOS ESTATUS DE FORMA MAS FACIL
			$model->id_usuario = Session::get("cod_usuario");  //DISEÑAR FUNCION PARA MANEJAR LOS ESTATUS DE FORMA MAS FACIL
			$model->save();

			foreach ($_POST["id_producto"] as $key => $value) {
				$solicitudClienteItems = new SolicitudClienteItems();
				$solicitudClienteItems->id_solicitud_cliente = $model->id_solicitud_cliente;
				$solicitudClienteItems->id_producto = $_POST["id_producto"][$key];
				$solicitudClienteItems->cantidad = $_POST["cantidad"][$key];
				$solicitudClienteItems->save();
			}
			$msg->sweetAlertMessage(swal2('','Solicitud Registrada'));
			$msg->success('test',ROUTER::create_action_url("solicitudes/default/list"));

			
		}else{

			$this->_view->titulo = "Agregar";
			$this->_view->script_propios = 'solicitud-scripts.js';
			$this->_view->render("_form", "default",[
				"form"=>$form,
				"clientes"=>$clientes,
				"productos"=>$productos
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}



	public function update($id){
		$solicitudes = SolicitudCliente::find($id);
		$form = new FormBuilder();
		$msg = new FlashMessages();
		$clientes = new Cliente();
		$productos = new Producto();
		$items = SolicitudClienteItems::whereRaw('id_solicitud_cliente = ? ', [$id])->get()->toArray();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {

			$solicitudes->id_cliente = $_POST["id_cliente"];
			$solicitudes->observacion = $_POST["observacion"];
			$solicitudes->save();
			
			Capsule::select('DELETE FROM solicitud_clientes_items WHERE id_solicitud_cliente = '.$id);

			if(isset($_POST["id_producto"])){
				foreach ($_POST["id_producto"] as $key => $value) {
					$solicitudClienteItems = new SolicitudClienteItems();
					$solicitudClienteItems->id_solicitud_cliente = $id;
					$solicitudClienteItems->id_producto = $_POST["id_producto"][$key];
					$solicitudClienteItems->cantidad = $_POST["cantidad"][$key];
					$solicitudClienteItems->save();
				}
			}

			
				$msg->sweetAlertMessage(swal2('','Solicitud Actualizada'));
				$msg->success('test',ROUTER::create_action_url("solicitudes/default/list"));
			
		}else{

			$this->_view->titulo = "Actualizar";
			$this->_view->script_propios = 'solicitud-scripts.js';
			$this->_view->render("_form", "default",[
				"form"=>$form,
				"solicitudes"=>$solicitudes,
				"clientes"=>$clientes,
				"productos"=>$productos,
				"items"=>$items
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}

	public function delete($id){
		$model = SolicitudCliente::find($id);
		$msg = new FlashMessages();
		
		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			Capsule::select('DELETE FROM solicitud_clientes_items WHERE id_solicitud_cliente = '.$id);
			if($model->delete()){
				$msg->sweetAlertMessage(swal2('','Solicitud Eliminada'));
				$msg->success('test',ROUTER::create_action_url("solicitudes/default/list"));
			}


		}else{

			$this->redirect("site/login");
		}
	}


	public function view($id){
		$solicitud = SolicitudCliente::find($id);
		//$componentes = $producto->componentes->toArray();

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			
			$this->_view->titulo = "Detalle";
			$this->_view->script_propios = 'solicitud-scripts.js';
			$this->_view->render("view", "default",[
				"solicitud"=>$solicitud,
			]);
		}else{

			$this->redirect("site/login");
		}
	}
}

?>