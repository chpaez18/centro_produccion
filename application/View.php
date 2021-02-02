<?php 
namespace Application;
use Models\Site;
use Application\Session;
use Application\Router;
use Plasticbrain\FlashMessages\FlashMessages;
/**
* 
*/

class View 
{
	
	private $_controlador;
	private $_microservice;

	public function __construct(Request $peticion){

		$this->_controlador = $peticion->getControlador();
		$this->_microservice = $peticion->getMicroservice();
	}	


	//metodo que renderiza las vistas
	public function render($vista, $item = false, $vars =[]){
		$model = new Site();
		$_layoutParams = array(

		


			'ruta_css' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/css/",

			//layout de control
			'ruta_assets' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/assets/",
			'ruta_scripts' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/scripts/",
			'ruta_styles' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/styles/",
			'ruta_modules' => BASE_URL . "../../modules/",
			//layout de control

			'ruta_img' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/img/",
			'ruta_js' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/js/",
			'ruta_lib' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/lib/",
			'ruta_font_awesome' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/font-awesome/css/",
			'ruta_froala' => BASE_URL . "../../views/layouts/" . DEFAULT_LAYOUT . "/froala/"
		);
		$msg = new FlashMessages();
		
		//foreach que por cada variable que venga, le sacamos la clave y el valor
		foreach ($vars as $key => $value) {
			$$key = $value;   //instanciamos una variable con el valor, para instanciar variables se usa 2 veces el $, $$key
		}

		//variable que contiene todas las opciones del menu

		if(Session::get("autenticado")){

			$menu = [

										[
											'id'=>'tab-solicitudes',
											'icon'=>'fi-page-edit',
											'titulo'=>'Solicitudes Clientes',
											'visible'=>Session::accesoViewEstricto(["1"]),
											'items'=>[
												[
													'titulo'=>'Solicitudes',
													'enlace'=> ROUTER::create_action_url("solicitudes/default/list"),
													'icon'=>'fas fa-clipboard-list',
													'visible'=>Session::accesoViewEstricto(["1"])
												],
												[
													'titulo'=>'Agregar',
													'enlace'=> ROUTER::create_action_url("solicitudes/default/create"),
													'icon'=>'fas fa-plus-square',
													'visible'=>Session::accesoViewEstricto(["1"])
												],
											]
										],
										[
											'id'=>'tab-solicitudes-almacen',
											'icon'=>'fi-page-edit',
											'titulo'=>'Solicitudes Almacén',
											'visible'=>Session::accesoViewEstricto(["1"]),
											'items'=>[
												[
													'titulo'=>'Solicitudes',
													'enlace'=> ROUTER::create_action_url("solicitudes/almacen/list"),
													'icon'=>'fas fa-clipboard-list',
													'visible'=>Session::accesoViewEstricto(["1"])
												],
												[
													'titulo'=>'Agregar',
													'enlace'=> ROUTER::create_action_url("solicitudes/almacen/create"),
													'icon'=>'fas fa-plus-square',
													'visible'=>Session::accesoViewEstricto(["1"])
												],
											]
										],
										[
											'id'=>'tab-solicitudes-produccion',
											'icon'=>'fi-page-edit',
											'titulo'=>'Solicitudes Producción',
											'visible'=>Session::accesoViewEstricto(["1"]),
											'items'=>[
												[
													'titulo'=>'Solicitudes',
													'enlace'=> ROUTER::create_action_url("solicitudes/produccion/list"),
													'icon'=>'fas fa-clipboard-list',
													'visible'=>Session::accesoViewEstricto(["1"])
												],
											]
										],
										[
											'id'=>'tab-solicitudes-materia-prima',
											'icon'=>'fi-page-edit',
											'titulo'=>'Solicitudes Materia Prima',
											'visible'=>Session::accesoViewEstricto(["1"]),
											'items'=>[
												[
													'titulo'=>'Solicitudes',
													'enlace'=> ROUTER::create_action_url("solicitudes/materia/list"),
													'icon'=>'fas fa-clipboard-list',
													'visible'=>Session::accesoViewEstricto(["1"])
												],
											]
										],
										[
											'id'=>'tab-solicitudes-compra',
											'icon'=>'fi-page-edit',
											'titulo'=>'Solicitudes Compras',
											'visible'=>Session::accesoViewEstricto(["1"]),
											'items'=>[
												[
													'titulo'=>'Solicitudes',
													'enlace'=> ROUTER::create_action_url("solicitudes/compra/list"),
													'icon'=>'fas fa-clipboard-list',
													'visible'=>Session::accesoViewEstricto(["1"])
												],
											]
										],

										[
											'id'=>'tab-clientes',
											'icon'=>'fas fa-shopping-bag',
											'titulo'=>'Clientes',
											'visible'=>Session::accesoViewEstricto(["1"]),
											'enlace'=> ROUTER::create_action_url("administracion/cliente/list"),
										],
										[
											'id'=>'tab-almacen',
											'icon'=>'fas fa-warehouse',
											'titulo'=>'Almacenes',
											'visible'=>Session::accesoViewEstricto(["1"]),
											'items'=>[
												[
													'titulo'=>'Almacenes',
													'enlace'=> ROUTER::create_action_url("administracion/almacen/list"),
													'icon'=>'fas fa-warehouse',
													'visible'=>Session::accesoViewEstricto(["1"])
												],
												[
													'titulo'=>'Inventario',
													'enlace'=> ROUTER::create_action_url("administracion/inventario/list"),
													'icon'=>'fas fa-dolly-flatbed',
													'visible'=>Session::accesoViewEstricto(["1"])
												],
											]
										],
										[
											'id'=>'tab-producto',
											'icon'=>'fas fa-box',
											'titulo'=>'Productos',
											'visible'=>Session::accesoViewEstricto(["1"]),
											'items'=>[
												[
													'titulo'=>'Productos',
													'enlace'=> ROUTER::create_action_url("administracion/producto/list"),
													'icon'=>'fas fa-box',
													'visible'=>Session::accesoViewEstricto(["1"])
												],
												[
													'titulo'=>'Componentes',
													'enlace'=> ROUTER::create_action_url("administracion/materia/list"),
													'icon'=>'fas fa-boxes',
													'visible'=>Session::accesoViewEstricto(["1"])
												]
											]
										],
										/*			
										[
										'id'=>'tab-notifications',
										'icon'=>'micon dw dw-calendar1',
										'titulo'=>'Notifications',
										'enlace' => ROUTER::create_action_url("notifications/default/index"),
										],			
										[
										'id'=>'tab-users',
										'icon'=>'micon dw dw-calendar1',
										'titulo'=>'Users',
										'enlace' => ROUTER::create_action_url("users/default/index"),
										],	*/		
										/*[
										'id'=>'productos',
										'titulo'=>'Productos',
										'enlace' => ROUTER::create_action_url("productos/list"),
										'icon'=>'fas fa-store'

										],			
										[
										'id'=>'productos',
										'titulo'=>'Agregrar Producto',
										'enlace' => ROUTER::create_action_url("productos/create"),
										'icon'=>'fas fa-plus'

										],	*/		

										/*
										[
											'id'=>'cerrar',
											'titulo'=>'Cerrar Sesión ('.Session::get("nom_usuario").")",
											'enlace' => ROUTER::create_action_url("site/cerrar")

										],*/


			];

		}else{
			/*
			$menu = [

					[
					'id'=>'login',
					'titulo'=>'Iniciar Sesión',
					'enlace' => ROUTER::create_action_url("site/login"),
					'icon'=>'fas fa-sign-in-alt'

					],

					[
					'id'=>'registro',
					'titulo'=>'Registro de Usuario',
					'enlace' => ROUTER::create_action_url("site/registro"),
					'icon'=>'fas fa-user-plus'

					]		

			];
			*/
		}
		


		
		if($this->_microservice){
			$rutaView = ROOT . "modules" . DS . $this->_microservice . DS . "views" . DS . $this->_controlador . DS . $vista . ".php";  //armamos la ruta hasta la vista
		}else{
			$rutaView = ROOT . "views" . DS . $this->_controlador . DS . $vista . ".php";  //armamos la ruta hasta la vista
		}
			//verificamos que el archivo sea legible
			if(is_readable($rutaView)){


				
				include_once ROOT . "views" . DS . "layouts" . DS . DEFAULT_LAYOUT . DS . "content.php";
                include_once ROOT . "views" . DS . "layouts" . DS . DEFAULT_LAYOUT . DS . "footer.php";


			}else{

				throw new \Exception("Vista no encontrada", 1);
				

			}

		
	}



}



?>