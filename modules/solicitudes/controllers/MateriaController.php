<?php
use Modules\solicitudes\models\SolicitudCliente;
use Modules\solicitudes\models\SolicitudClienteItems;
use Modules\solicitudes\models\SolicitudProduccion;
use Modules\solicitudes\models\SolicitudAlmacenMateriaPrima;
use Modules\solicitudes\models\SolicitudAlmacenProducto;
use Modules\solicitudes\models\SolicitudCompras;
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
class MateriaController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}

	public function index(){}

	public function list(){
		$solicitudes = new SolicitudAlmacenMateriaPrima();
		$form = new FormBuilder();
		$dataProvider = $solicitudes->getSolicitudesAlmacenMateriaPrima();
		
		if(Session::get("autenticado")){
            
            Session::accesoEstricto(["1"]);

			$this->_view->titulo = "Listado";
			$this->_view->script_propios = 'solicitud-materia-scripts.js';
			$this->_view->datatable = 'solicitudes-materia-listado';
			
			$this->_view->render("list", "materia",[
				"form"=>$form,
				"dataProvider"=>$dataProvider,
				"solicitudes"=>$solicitudes
			]);

		}else{

			$this->redirect("site/login");
		}
    }
    

	public function deliver($id_materia_prima, $id_solicitud_almacen_materia_prima){
        $msg = new FlashMessages();
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);
            $record = SolicitudAlmacenMateriaPrima::where('id_solicitud_almacen_materia_prima', '=', $id_solicitud_almacen_materia_prima)
            ->update(['estatus' => 1, 'entregado_por'=> Session::get("cod_usuario")]);
            
            if($record){
                $msg->sweetAlertMessage(swal2('','Materia Prima Entregada'));
			    $msg->success('test',ROUTER::create_action_url("solicitudes/materia/list"));
            }
		}else{

			$this->redirect("site/login");
		}	
    }
    
    public function requestBuy(){
        $data = $_POST['data'];

        $model = new SolicitudCompras();
        $model->id_solicitud_almacen_materia_prima = $data["id_solicitud_almacen_materia_prima"];
        $model->id_materia_prima = $data["id_materia_prima"];
        $model->fecha_registro = date("Y-m-d h:i:s");
        $model->cantidad = $data["cantidad"];
        $model->unidad = $data["unidad"];
        $model->estatus = 0;
        $model->solicitado_por = Session::get("cod_usuario");

        if($model->save()){
            return true;
        }else{
            return false;
        }
    }
}

?>