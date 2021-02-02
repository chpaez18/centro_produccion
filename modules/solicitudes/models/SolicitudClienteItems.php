<?php
namespace Modules\solicitudes\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
use Modules\administracion\models\Producto;

/**
* 
*/
class SolicitudClienteItems extends Model
{
    protected $table = 'solicitud_clientes_items';
    public $primaryKey = 'id_solicitud_cliente_item';
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

    public function solicitudAlmacenProducto(){
        return $this->hasOne(SolicitudAlmacenProducto::class,'id_solicitud_cliente','id_solicitud_cliente');
    }

    public function getEstatusAlmacen(){
        return [
            "No atendida"=>0,
            "Solicitado"=>1,
            "Entregado"=>2
        ];
    }
    public function getEstatusProduccion(){
        return [
            "No atendida"=>0,
            "Solicitado"=>1,
            "Entregado"=>2
        ];
    }
}
?>