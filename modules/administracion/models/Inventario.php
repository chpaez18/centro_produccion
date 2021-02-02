<?php
namespace Modules\administracion\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
use Application\Utilities;

use Modules\administracion\models\Almacen;
use Modules\administracion\models\Producto;
use Modules\administracion\models\Materia;
/**
* 
*/
class Inventario extends Model
{
    protected $table = 'inventario';
    public $primaryKey = 'id_inventario';
    public $timestamps = false;
    protected $fillable = ["id_inventario","id_almacen", "tipo", "id_producto", "id_materia_prima", "cantidad", "fecha_registro", "fecha_carga","estatus"];
    
    public function getLabels(){
        return [
            "id_inventario" => "Inventario",
            "id_almacen" => "Almacen",
            "tipo" => "Tipo",
            "id_producto" => "Producto",
            "id_materia_prima" => "Materia Prima",
            "cantidad" => "Cantidad",
            "fecha_registro" => "Fecha Registro",
            "fecha_carga" => "Fecha Carga",
            "estatus" => "Estatus",
            "almacen.nombre" => "Nombre Almacen",
            "producto.nombre" => "Nombre Producto",
        ];
    }
    public function getInventarios(){
        //$inventarios = Inventario::orderBy('id_inventario','asc')->get()->toArray();
        $inventarios = Inventario::all()->toArray();
        $data = Utilities::buildRelation(new Inventario,['almacen'],$inventarios,"All",'hasMany',['almacen']);
        
        if($data){
            return $data;
        }else{
            return false;
        }

    }


    /* RELATIONS */
    public function almacen()
    {
        return $this->hasOne(Almacen::class,'id_almacen','id_almacen');
    }

    public function producto()
    {
        return $this->hasOne(Producto::class,'id_producto','id_producto');
    }
    public function materia()
    {
        return $this->hasOne(Materia::class,'id_materia_prima','id_materia_prima');
    }

}
?>