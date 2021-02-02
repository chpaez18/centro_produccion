<?php
use Modules\solicitudes\models\SolicitudCliente;
use Modules\solicitudes\models\SolicitudClienteItems;
use Modules\solicitudes\models\SolicitudAlmacenProducto;
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
class AlmacenController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}

	public function index(){}

	public function list(){
		$solicitudes = new SolicitudAlmacenProducto();
		$form = new FormBuilder();
		$dataProvider = $solicitudes->getSolicitudesAlmacenProducto();
		$solicitudCliente = new SolicitudCliente();
		
		if(Session::get("autenticado")){
            
            Session::accesoEstricto(["1"]);

			$this->_view->titulo = "Listado Solicitudes del Almacén";
			$this->_view->script_propios = 'solicitud-almacen-scripts.js';
			$this->_view->datatable = 'solicitudes-almacen-listado';
			
			$this->_view->render("list", "almacen",[
				"form"=>$form,
				"dataProvider"=>$dataProvider,
				"solicitudes"=>$solicitudes,
				"solicitudCliente"=>$solicitudCliente
			]);

		}else{

			$this->redirect("site/login");
		}
	}

	public function create(){
        $solicitud = new SolicitudAlmacenProducto();
		$form = new FormBuilder();
        $msg = new FlashMessages();
        $solicitudCliente = new SolicitudCliente();
        $solicitudClienteItems = new SolicitudClienteItems();

		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {

            $model = new SolicitudAlmacenProducto ($_POST);
            $model->fecha_registro = date("Y-m-d h:i:s");
            $model->solicitado_por = Session::get("cod_usuario");
            $model->observacion = $_POST["observacion"];
            
			if($model->save()){
                Utilities::changeEstatus($solicitudCliente, 'id_solicitud_cliente', $model->id_solicitud_cliente, 'Atendida en Espera', 'getEstatus', 'estatus');
                Utilities::changeEstatus($solicitudClienteItems,'id_solicitud_cliente', $model->id_solicitud_cliente, 'Solicitado', 'getEstatusAlmacen','estatus_almacen');
				$msg->sweetAlertMessage(swal2('','Solicitud Registrada'));
				$msg->success('test',ROUTER::create_action_url("solicitudes/almacen/list"));
			}
			
		}else{

			$this->_view->titulo = "Agregar solicitud";
			$this->_view->script_propios = 'solicitud-almacen-scripts.js';
			$this->_view->render("_form", "almacen",[
				"form"=>$form,
				"solicitudCliente"=>$solicitudCliente
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}


/*
	public function update($id){
		$solicitud = SolicitudAlmacenProducto::find($id);
		$form = new FormBuilder();
		$msg = new FlashMessages();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {
			
			$model = Utilities::fillData($solicitud, $_POST);

			if($model->save()){
				$msg->sweetAlertMessage(swal2('','Solicitud Actualizada'));
				$msg->success('test',ROUTER::create_action_url("solicitudes/almacen/list"));
			}
			
		}else{

			$this->_view->titulo = "Actualizar Solicitud";
			$this->_view->script_propios = 'solicitud-almacen-scripts.js';
			$this->_view->render("_form", "almacen",[
				"form"=>$form,
				"solicitud"=>$solicitud
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}
*/

	public function delete($id){
		$model = SolicitudAlmacenProducto::find($id);
        $msg = new FlashMessages();
        $solicitudCliente = new SolicitudCliente();
        $solicitudClienteItems = new SolicitudClienteItems();

        Utilities::changeEstatus($solicitudCliente, 'id_solicitud_cliente', $model->id_solicitud_cliente, 'No atendida', 'getEstatus', 'estatus');
        Utilities::changeEstatus($solicitudClienteItems,'id_solicitud_cliente', $model->id_solicitud_cliente, 'No atendida', 'getEstatusAlmacen','estatus_almacen');
		
		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			if($model->delete()){
				$msg->sweetAlertMessage(swal2('','Solicitud Eliminada'));
				$msg->success('test',ROUTER::create_action_url("solicitudes/default/list"));
			}


		}else{

			$this->redirect("site/login");
		}
	}


	public function view($id){
		$solicitud = SolicitudAlmacenProducto::find($id);
		//$componentes = $producto->componentes->toArray();

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			
			$this->_view->titulo = "Detalle Solicitud Almacén";
			$this->_view->script_propios = 'solicitud-almacen-scripts.js';
			$this->_view->render("view", "almacen",[
				"solicitud"=>$solicitud,
			]);
		}else{

			$this->redirect("site/login");
		}
    }
    
    public function changeEstatusProducto($id){
        $msg = new FlashMessages();
		if(Session::get("autenticado")){
            $producto = SolicitudClienteItems::find($id);
            if($producto->estatus_almacen == 1){
                $producto->estatus_almacen = 2;
                if($producto->save()){
                    $msg->sweetAlertMessage(swal2('','Producto Entregado'));
                    $msg->success('test',ROUTER::create_action_url("solicitudes/almacen/view",[$producto->solicitudAlmacenProducto->id_solicitud_almacen_producto]));
                }
            }else if ($producto->estatus_almacen == 2){
                $producto->estatus_almacen = 1;
                if($producto->save()){
                    $msg->sweetAlertMessage(swal2('','Producto Solicitado'));
                    $msg->success('test',ROUTER::create_action_url("solicitudes/almacen/view",[$producto->solicitudAlmacenProducto->id_solicitud_almacen_producto]));
                }
            }

		}else{

			$this->redirect("site/login");
		}
	}
	

    public function entregar($id){
        $msg = new FlashMessages();
		if(Session::get("autenticado")){
            $solicitudAlmacen = SolicitudAlmacenProducto::find($id);
			$solicitudCliente = SolicitudCliente::find($solicitudAlmacen->id_solicitud_cliente);
			$solicitudCliente->estatus = 3;
            $solicitudAlmacen->estatus = 1;
            $solicitudAlmacen->entregado_por = Session::get("cod_usuario");
            $solicitudAlmacen->fecha_recepcion = date("Y-m-d h:i:s");
            if($solicitudAlmacen->save() && $solicitudCliente->save()){
                $msg->sweetAlertMessage(swal2('','Solicitud Entregada'));
                $msg->success('test',ROUTER::create_action_url("solicitudes/almacen/list"));
            }

		}else{

			$this->redirect("site/login");
		}
    }
}

?>