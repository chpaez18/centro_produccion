<?php
namespace Modules\administracion\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
/**
* 
*/
class Almacen extends Model
{
    protected $table = 'almacenes';
    public $primaryKey = 'id_almacen';
    public $timestamps = false;
    protected $fillable = ["id_almacen","nombre", "ubicacion"];
    
    public function getLabels(){
        return [
            "nombre" => "Nombre Almacen",
            "ubicacion" => "Ubicacion Almacen",
        ];
    }

    public function getAlmacenes(){
        $almacenes = Almacen::orderBy('id_almacen','desc')->get()->toArray();
        
        if($almacenes){
            return $almacenes;
        }else{
            return false;
        }

    }
}
?>