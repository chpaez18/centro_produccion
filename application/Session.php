<?php 
namespace Application;
use Models\Site;
use Application\Session;
/**
Clase que proporciona los metodos para el manejo de sesiones, variables de sesion etc
*/

class Session 
{
	
	public static function init()
	{

		session_start();

	}

	//metodo para destruir una variable de sesion, o varias dentro de un arreglo

	public static function destroy($clave = false)
	{

		//verificamos si se envio una clave

		if($clave){

			//verificamos primero si es un arreglo
			if(is_array($clave)){

				//recorremos el arreglo y por cada coincidencia eliminamos esa variable

				for($i = 0; $i< count($clave); $i++){

					//verificamos si existe esa variable de sesion

					if(isset($_SESSION[$clave[$i]])){

						unset($_SESSION[$clave[$i]]);//si existe, le hacemos un unset a esa variable
					}

				}
			}else{

				if(isset($_SESSION[$clave])){

						unset($_SESSION[$clave]);//si existe, le hacemos un unset a esa variable
				}

			}


		}else{
			$model = new Site();
			//en caso de que no se haya enviado una clave, se hace un session_destroy()
			$id_user = Session::get("cod_usuario");
			session_destroy();
		}



	}


	//este metodo recibira un nombre de variable de sesion y un valor y lo asignara como varible de sesion
	public static function set($clave, $valor)
	{

		if(!empty($clave)){
			$_SESSION[$clave] = $valor;
		}

	}


	public static function get($clave)
	{

		if(isset($_SESSION[$clave])){

			return $_SESSION[$clave];
		
		}

	}
/*
	//metodo para controlar el tiempo de sesion del usuario
	public static function tiempo()
	{

		//verificamos si hay una variable de sesion, o esta definida la constante de session_time
		if(!Session::get("tiempo") || !defined("SESSION_TIME")){

			throw new Exception("No se ha definido el tiempo de sesion");
			
		}

		if(SESSION_TIME == 0){

			return;

		}

		//restamos el tiempo actual, al tiempo cuando el usuario inicio sesion, y si ese tiempo es mayor al session_time * 60 esto por que time() devuelve el tiempo en segundos, y para convertirlo en minutos lo multiplicamos por 60
		if(time() - Session::get("tiempo") > (SESSION_TIME * 60)){
			
			Session::destroy();
			header("location: index.php?url=error/access/8080");
		}else{
			//si todavia esta dentro del tiempo de sesion, reiniciamos ese tiempo, y ponemos el tiempo actual como valor
			Session::set("tiempo", time());
		}


	}
*/

	public static function acceso($level)
	{
		//si el usuario no esta autenticado
		if(!Session::get("autenticado")){

			header("location: index.php?url=error/access/error/5050");
			exit;

		}

		//hacemos el metodo de verificacion del tiempo en sesion
		//Session::tiempo();

		//level hace referencia a una variable de session que guardaremos cuando el usuario inicie sesion y sera el nivel de acceso que tendra ese usuario

		//CAMBIAR != POR > PARA DEJARLO COMO ANTES
		if(Session::getLevel($level) != Session::getLevel(Session::get("level")) ){

			header("location: index.php?url=error/access/error/401");
			exit;

		}


	}

	//metodo para restringir el acceso al usuario en la parte de la vista
	public static function accesoView($level)
	{

		//si el usuario no esta autenticado
		if(!Session::get("autenticado")){

			return false;
		}

		//level hace referencia a una variable de session que guardaremos cuando el usuario inicie sesion y sera el nivel de acceso que tendra ese usuario
		if(Session::getLevel($level) > Session::getLevel(Session::get("level"))){

			return false;

		}

		return true;

	}

	//metodo que contiene los diferentes niveles de acceso dentro de la aplicacion
	public static function getLevel($level)
	{

		$rol["1"] = 1; //SUPER ADMIN
		$rol["2"] = 2; //Control de Estudio CUFM
		$rol["3"] = 3; //Vencedor
		$rol["4"] = 4; //Coordinador Aldea

		if(!array_key_exists($level, $rol)){

			throw new Exception("Error de Acceso");

		}else{

			return $rol[$level];

		}

	}

	//metodo que permite darle permisos a ciertos grupos de usuarios especificos 
	public static function accesoEstricto(array $level, $noAdmin = false)
	{

		if(!Session::get("autenticado")){

			header("location: index.php?url=error/access/error/5050");
			exit;

		}

		//hacemos el metodo de verificacion del tiempo en sesion
		//Session::tiempo();

		//verificamos si se envio el parametro noAdmin
		if($noAdmin == false){
			if(Session::get("level") == "1"){
				return;
			}

		}

		//verificamos los niveles de usuario que van a ser permitidos
		if(count($level)){
			
			//si se encuentra dentro del arreglo de level, permite el acceso
			if(in_array(Session::get("level"), $level)){
				return;
			}
		}	
			
		header("location: index.php?url=error/access/error/401");
	}

	public static function accesoViewEstricto(array $level, $noAdmin = false)
	{

		if(!Session::get("autenticado")){

			return false;

		}

		//hacemos el metodo de verificacion del tiempo en sesion
		//Session::tiempo();

		//verificamos si se envio el parametro noAdmin
		if($noAdmin == false){
			if(Session::get("level") == "admin"){
				return true;
			}

		}

		//verificamos los niveles de usuario que van a ser permitidos
		if(count($level)){
			
			//si se encuentra dentro del arreglo de level, permite el acceso
			if(in_array(Session::get("level"), $level)){
				return true;
			}
		}	
			
		return false;

	}
}

?>