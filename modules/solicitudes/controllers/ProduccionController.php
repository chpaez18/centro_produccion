<?php
use Modules\solicitudes\models\SolicitudCliente;
use Modules\solicitudes\models\SolicitudClienteItems;
use Modules\solicitudes\models\SolicitudProduccion;
use Modules\solicitudes\models\SolicitudAlmacenMateriaPrima;
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
class ProduccionController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}

	public function index(){}

	public function list(){
		$solicitudes = new SolicitudProduccion();
		$form = new FormBuilder();
		$dataProvider = $solicitudes->getSolicitudesProduccion();
		
		if(Session::get("autenticado")){
            
            Session::accesoEstricto(["1"]);

			$this->_view->titulo = "Listado";
			$this->_view->script_propios = 'solicitud-produccion-scripts.js';
			$this->_view->datatable = 'solicitudes-produccion-listado';
			
			$this->_view->render("list", "produccion",[
				"form"=>$form,
				"dataProvider"=>$dataProvider,
				"solicitudes"=>$solicitudes
			]);

		}else{

			$this->redirect("site/login");
		}
	}


	public function request(){
		$data = $_POST['data'];
		//var_dump($data);die();
        $solicitudAlmacenProducto = SolicitudAlmacenProducto::find($data["solicitud_almacen_producto"]);
        $producto = Producto::find($data["id_producto"]);
		$msg = new FlashMessages();
		//var_dump($producto);die();
        
        $solicitudProduccion = new SolicitudProduccion();
        $solicitudProduccion->id_solicitud_almacen_producto = $solicitudAlmacenProducto->id_solicitud_almacen_producto;
        $solicitudProduccion->id_producto = $producto->id_producto;
        $solicitudProduccion->cantidad = $data["cantidad"];
        $solicitudProduccion->estatus = $solicitudProduccion->getEstatus()["Solicitado"];
        $solicitudProduccion->fecha_registro = date("Y-m-d h:i:s");
        $solicitudProduccion->solicitado_por = Session::get("cod_usuario");

        if($solicitudProduccion->save()){
            $id_solicitud_cliente = $solicitudProduccion->solicitudAlmacenProducto->solicitudCliente->id_solicitud_cliente;
            $model = SolicitudClienteItems::where(["id_solicitud_cliente"=>$id_solicitud_cliente, "id_producto"=>$solicitudProduccion->id_producto])->update(['estatus_produccion' => 1]);
            if($model){
                return true;
            }else{
                return false;
            }
        }

	}

	public function view($id){
		$solicitud = SolicitudProduccion::find($id);
		//$componentes = $producto->componentes->toArray();
		$solicitudMateria = SolicitudAlmacenMateriaPrima::where('id_solicitud_produccion', '=', $id)->get();
		

		if(Session::get("autenticado")){
			Session::accesoEstricto(["1"]);
			
			$this->_view->titulo = "Detalle Solicitud Producción";
			$this->_view->script_propios = 'solicitud-produccion-scripts.js';
			$this->_view->render("view", "produccion",[
				"solicitud"=>$solicitud,
				"solicitudMateria"=>$solicitudMateria,
			]);
		}else{

			$this->redirect("site/login");
		}
	}

	public function requestAlmacen($id_solicitud_produccion, $id_materia_prima){
        $msg = new FlashMessages();
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

			$model = new SolicitudAlmacenMateriaPrima ();
			$model->id_solicitud_produccion = $id_solicitud_produccion;
			$model->id_materia_prima = $id_materia_prima;
			$model->fecha_registro = date("Y-m-d h:i:s");
			$model->estatus = 0;  
			$model->solicitado_por = Session::get("cod_usuario");  
			$model->save();

			$msg->sweetAlertMessage(swal2('','Solicitud Registrada'));
			$msg->success('test',ROUTER::create_action_url("solicitudes/produccion/view",[$id_solicitud_produccion]));
		}else{

			$this->redirect("site/login");
		}	
	}
	
	public function entregarProducto($id_solicitud_produccion, $id_producto){
		$solicitud = SolicitudProduccion::find($id_solicitud_produccion);
		$model = SolicitudProduccion::where(["id_solicitud_produccion"=>$id_solicitud_produccion, "id_producto"=>$id_producto])
		->update(['estatus' => 1, 'entregado_por'=>Session::get("cod_usuario")]);
		$msg = new FlashMessages();
		if($model){
			$model = SolicitudClienteItems::where(["id_solicitud_cliente"=>$solicitud->solicitudAlmacenProducto->id_solicitud_cliente, "id_producto"=>$id_producto])->update(['estatus_produccion' => 2]);
			$msg->sweetAlertMessage(swal2('','Producto Entregado'));
			$msg->success('test',ROUTER::create_action_url("solicitudes/produccion/list"));
		}
	}
}

?>