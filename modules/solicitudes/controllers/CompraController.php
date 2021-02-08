<?php
use Modules\solicitudes\models\SolicitudCompras;
use Modules\administracion\models\Cliente;
use Modules\administracion\models\Producto;
use Modules\administracion\models\Materia;
use Modules\administracion\models\Inventario;
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
class CompraController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}

	public function index(){}

	public function list(){
		$solicitudes = new SolicitudCompras();
		$form = new FormBuilder();
		$dataProvider = $solicitudes->getSolicitudesCompras();
		
		if(Session::get("autenticado")){
            
            Session::accesoEstricto(["1"]);

			$this->_view->titulo = "Listado";
			$this->_view->script_propios = 'solicitud-compra-scripts.js';
			$this->_view->datatable = '';
			
			$this->_view->render("list", "compra",[
				"form"=>$form,
				"dataProvider"=>$dataProvider,
				"solicitudes"=>$solicitudes
			]);

		}else{

			$this->redirect("site/login");
		}
    }

    public function buy($id_solicitud_compra){
        $msg = new FlashMessages();
		if(Session::get("autenticado")){
            $model = SolicitudCompras::find($id_solicitud_compra);
            $model->estatus = 1;

            if($model->save()){
                $msg->sweetAlertMessage(swal2('','Materia prima comprada'));
                $msg->success('test',ROUTER::create_action_url("solicitudes/compra/list"));
            }

		}else{

			$this->redirect("site/login");
        }
    }

    public function generalBuy(){
        $data = $_POST['data'];
        $materia = new Materia();
        $id_materia_prima = $data["id_materia_prima"];
        $cant_total = (int)$data["total"];
        $id_solicitud_almacen_materia_prima = (int) $data["id_solicitud_almacen_materia_prima"];
        $inventario = Inventario::where('id_materia_prima', '=', $id_materia_prima)
        ->where('tipo', '=', 0)
        ->where('estatus', '=', 1)
        ->first();
        $total = (int)$cant_total + $inventario->cantidad;
        $inventario->cantidad = $total;

        /* AÑADIR FUNCIONALIDAD PARA REGISTRAR HISTORICO Y 
        MOVIMIENTO DEL INVENTARIO Y/O MATERIA PRIMA */

        if($inventario->update()){
            $record = SolicitudCompras::where('id_materia_prima', '=', $id_materia_prima)
            ->where('id_solicitud_almacen_materia_prima', '=', $id_solicitud_almacen_materia_prima)
            ->update(['estatus' => 1, 'entregado_por'=> Session::get("cod_usuario")]);
        }else{
            return false;
        }
        if($record){
            return true;
        }else{
            return false;
        }
    }

    public function deliver($id_solicitud_compra){
        $msg = new FlashMessages();
		if(Session::get("autenticado")){
            $model = SolicitudCompras::find($id_solicitud_compra);
            $record = SolicitudCompras::where('id_materia_prima', '=', $model->id_materia_prima)
            ->where('id_solicitud_almacen_materia_prima', '=', $model->id_solicitud_almacen_materia_prima)
            ->update(['estatus' => 2, 'entregado_por'=>Session::get("cod_usuario")]);
            if($record){
                $msg->sweetAlertMessage(swal2('','Materia prima entregada'));
                $msg->success('test',ROUTER::create_action_url("solicitudes/compra/list"));
            }
            

		}else{

			$this->redirect("site/login");
        }
    }
    
}

?>