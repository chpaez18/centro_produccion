<?php
namespace Modules\administracion\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
/**
* 
*/
class Producto extends Model
{
    protected $table = 'productos';
    public $primaryKey = 'id_producto';
    public $timestamps = false;
    protected $fillable = ["nombre", "description"];

    public function getLabels(){
        return [
            "nombre" => "Nombre Producto",
        ];
    }
    
    public function getProductos(){
        //$clientes = Cliente::all()->toArray();
        $productos = Producto::where('estatus', '=', 1)->orderBy('id_producto','desc')->get()->toArray();
        if($productos){
            return $productos;
        }else{
            return false;
        }

    }

    public function componentes(){
        return $this->hasMany(ProductoComponente::class,'id_producto','id_producto');
    }

    public function getCustomName(){
        
        return $this->nombre;
    }
    
}
?>