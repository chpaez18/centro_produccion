<?php
namespace Application;
use \Illuminate\Database\Eloquent\Model;
use Modules\administracion\models\Inventario;
/**
*
Clase que contiene varias funciones utilitarias para la aplicación
*/
class Utilities extends Model
{
	

	/*=============
	retorna un string filtrado, sin acentos, tildes etc.
	===============*/
	static function cleanString($cadena) {

		//$cade = utf8_decode($cadena);

		$no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
		
		$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
	}	


	/*=============
	nos devuelve la fecha formateada en español
		Formato de $date = yyyy-mm-dd
		retorna = dd/mm/yyyy
	===============*/
	static function FormatDateEs($date) {
		$l = strlen($date);
		$res = "";
		if ($l >= 10) {
			$res = substr($date,8,2)."/".substr($date,5,2)."/".substr($date,0,4);
				
		}
		return($res);
	}


	/*=============
	Retorna un valor enviado por GET
	===============*/

	static function RequestGet($var) {
		$res = "";
		if(isset($_REQUEST[$var])){
			$res = $_REQUEST[$var];
		}
			
		return $res;
	}


	/*=============
	Retorna true si $val tiene informacion, y false si no tiene, funcion para validar campos de formularios por ejemplo
	===============*/
	static function validate($val) {
		$res = false;
		if (isset($val) && ($val != "")){
			$res = true;
		}
		return ($res);
	}

	/*=============
	Valida que la cadena no contenga caracteres especiales, y admita solo caracteres alfabeticos
	===============*/
 	static function validateEspecialChars($val) {
		$res = false;
		if (isset($val) && ($val != "") && preg_match("/^[a-zA-Záéíóúñ()0-9\s]+$/i",$val)){
			$res = true;
		}
		return ($res);
	}


	/*=============
	Funcion para construir un array, el & en el parametro quiere decir que la funcion solo recibira parametros por referencia, es decir guardadas en una variable
	===============*/
		function buildArray(&$A)  {
			$cant = count($A);
			$B = [];
			
			$B[] = $A;
	
			return $B;
		}

	/*=============
	Retorna un alert con un mensaje especifico
	===============*/
	static function alert($msg) {
		$msg = str_replace('"','', $msg);
		$msg = str_replace("'","", $msg);
		echo '<SCRIPT language="javascript" type="text/javascript">';
			echo 'alert("'.$msg.'");'; 
        echo '</SCRIPT>';
   	}


   /**
     * AGREGADO CHRISTIAN 
     * Arma un array con las respectivas relaciones, para un solo objeto o un array con varios registros
     *
     * @param  object $class  una instancia del objeto de la tabla donde se trabajara
     * @param  array $relation_name  array con el nombre de las funciones respectivas de relacion, definidas dentro del propio modelo
     * @param  array $model  objeto o un array con toda la informacion de la tabla
     * @param  string $type  establece como llega la informacion, Single si es un objeto con un solo registro o All para un array con varios registros.
     * @param  string $type_relation  si se define como hasMany la funcion evaluara las relaciones hasMany de uno a muchos y armara el arreglo, hasOne de uno a uno y armara el arreglo segun los nombres de las respectivas funciones establecidas en $names_relations
     * @param  string $names_relations  los nombres de las relaciones hasMany
     * @return  $array
     */
    static public function buildRelation($class, $relation_name, $model, $type, $type_relation, $names_relations = false){
        $nameClass = get_class($class);
        //var_dump($class);die();
        if($type == "All"){
            foreach($model as $key => $value){
                $array[$key] = $value;
                $aux = $class::find($value[$class->primaryKey]);
                if($type_relation == "hasMany"){
                    foreach($names_relations as $index =>$namesR){
                        $relation = $aux->$namesR->toArray();
                        $array[$key][$namesR] = $relation;
                        $relation = [];
                    }
                }elseif($type_relation == "hasOne"){
                    foreach($relation_name as $name){
                        $relation = $aux->$name->toArray();
                        $array[$key][$name] = $relation;
                    }
                }
            }
            return $array;
        }elseif($type == "Single"){
            $array = $model;
            foreach($relation_name as $name){
                $array[$name] = $model->$name->toArray();
            }
            return $array;
        }
	}
	
    /**
     * AGREGADO CHRISTIAN 
     * retorna un objeto con la data que es enviada via POST
     *
     * @param  object $model  una instancia del objeto de la tabla donde se trabajara
     * @param  array $data  array con la informacion que fue enviada via POST
     * @return  $array
    */
    static public function fillData($model, $data){

        foreach($data as $key=>$value){
            $model->$key = $value;
		}
        return $model;
    }

	static public function changeEstatus($model, $condition, $id, $estatus, $nameFunction, $field){
		$model::where($condition,$id)
        ->update([$field => $model->$nameFunction()[$estatus]]);
	}

}

?>