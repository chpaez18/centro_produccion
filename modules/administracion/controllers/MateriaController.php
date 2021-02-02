<?php
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
class MateriaController extends Controller
{

	//metodo que llama al metodo constructor de la clase padre
	public function __construct(){

		parent::__construct();

	}

    public function index(){}
	
	
	public function list(){
		$materia = new Materia();
		$form = new FormBuilder();
		$dataProvider = $materia->getMaterias();
		
		if(Session::get("autenticado")){
            
            Session::accesoEstricto(["1"]);

			$this->_view->titulo = "Listado";
			$this->_view->script_propios = 'materia-scripts.js';
			$this->_view->datatable = 'materias-listado';
			
			$this->_view->render("list", "materia",[
				"form"=>$form,
				"dataProvider"=>$dataProvider,
				"materia"=>$materia
			]);

		}else{

			$this->redirect("site/login");
		}
	}

	public function create(){
        $materia = new Materia();
		$form = new FormBuilder();
		$msg = new FlashMessages();

		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {

			$model = new Materia ($_POST);
			if($model->save()){
				$msg->sweetAlertMessage(swal2('','Materia Prima Registrada'));
				$msg->success('test',ROUTER::create_action_url("administracion/materia/list"));
			}
			
		}else{

			$this->_view->titulo = "Agregar";
			$this->_view->script_propios = 'materia-scripts.js';
			$this->_view->render("_form", "materia",[
				"form"=>$form
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}



	public function update($id){
		$materia = Materia::find($id);
		$form = new FormBuilder();
		$msg = new FlashMessages();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);

		if (!empty($_POST)) {
			
			$model = Utilities::fillData($materia, $_POST);

			if($model->save()){
				$msg->sweetAlertMessage(swal2('','Materia Prima Actualizada'));
				$msg->success('test',ROUTER::create_action_url("administracion/materia/list"));
			}
			
		}else{

			$this->_view->titulo = "Actualizar";
			$this->_view->script_propios = 'materia-scripts.js';
			$this->_view->render("_form", "materia",[
				"form"=>$form,
				"materia"=>$materia
			]);
		}

		}else{

			$this->redirect("site/login");
		}
	}

	public function delete($id){
		$model = Materia::find($id);
		$msg = new FlashMessages();
		
		if(Session::get("autenticado")){
            Session::accesoEstricto(["1"]);
			if($model->delete()){
				$msg->sweetAlertMessage(swal2('','Materia Prima Eliminada'));
				$msg->success('test',ROUTER::create_action_url("administracion/materia/list"));
			}


		}else{

			$this->redirect("site/login");
		}
	}
}

?>