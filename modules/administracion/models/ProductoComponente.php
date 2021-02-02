<?php
namespace Modules\administracion\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
use Modules\administracion\models\Producto;
use Modules\administracion\models\Materia;
/**
* 
*/
class ProductoComponente extends Model
{
    protected $table = 'productos_componentes';
    public $primaryKey = 'id_producto_componente';
    public $timestamps = false;

    
    public function getProductos(){
        //$clientes = Cliente::all()->toArray();
        $productos =Producto::orderBy('id_producto','asc')->get()->toArray();
        
        if($productos){
            return $productos;
        }else{
            return false;
        }

    }

    public function producto(){
        return $this->hasOne(Producto::class,'id_producto','id_producto');
    }
    public function materia(){
        return $this->hasOne(Materia::class,'id_materia_prima','id_materia_prima');
    }
    public function getCantMateria(){
        return $this->cantidad;
    }
}
?>