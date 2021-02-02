<?php 
use Application\Controller;
/**
Controlador que nos servira para los mensajes de error que tengamos que mostrar al usuario en conjunto con el layout
*/
class AccessController extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{

		$this->_view->titulo = "Error";	

		//enviamos el mensaje
		$this->_view->content = $this->_getError();
		$this->_view->render("index");		
		
	}	


	//metodos por categoria de errores

	public function error($codigo)
	{

		$this->_view->titulo = "Error";	
		//var_dump($this->_view->titulo);die();
		//enviamos el mensaje
		$this->_view->content = $this->_getError($codigo);
		$this->_view->render("index", "error");

	}


	private function _getError($codigo = false)
	{

		if($codigo){

			//recibimos el codigo y lo filtramos
			$codigo = $this->filtrarInt($codigo);

			//verificamos que el codigo sea entero
			if(is_int($codigo)){

				$codigo = $codigo;
			
			}

		}else{

			$codigo = "404";
		}
		

		//armamos un arreglo asociativo de errores
		$error["404"] = ["tittle"=>"Recurso no disponible", "message"=>"Ha ocurrido un error y la página no puede mostrarse", "code"=>"404"];  //establecemos un mensaje de error por default

		$error["401"] = ["tittle"=>"Acceso Restringido", "message"=>"No tiene permisologia para visualizar esta página", "code"=>"401"];


		//verificamos que exista en el arreglo el codigo
		if(array_key_exists($codigo, $error)){
			
			return $error[$codigo];
		
		}else{

			return $error["404"];

		}

	}

}

?>