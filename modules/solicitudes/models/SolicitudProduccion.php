<?php
namespace Modules\solicitudes\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
use Application\Utilities;
use Modules\administracion\models\Cliente;
use Modules\administracion\models\Producto;
use Illuminate\Database\Capsule\Manager as Capsule;
/**
* 
*/
class SolicitudProduccion extends Model
{
    protected $table = 'solicitud_produccion';
    public $primaryKey = 'id_solicitud_produccion';
    public $timestamps = false;
    protected $fillable = [
        "id_solicitud_almacen_producto", 
        "id_producto", 
        "cantidad", 
        "estatus",
        "fecha_registro",
        "solicitado_por",
        "entregado_por",
    ];

    public function getLabels(){
        return [
            "id_solicitud_almacen_producto" => "Solicitud Almacen",
            "id_producto" => "Producto",
            "cantidad" => "Cantidad Solicitada",
            "estatus" => "Estatus",
            "fecha_registro" => "Fecha Registro",
            "solicitado_por" => "Solicitado Por",
            "entregado_por" => "Entregado Por",
        ];
    }
    
    public function getSolicitudesProduccion(){
        //$clientes = Cliente::all()->toArray();
        $solicitudes = SolicitudProduccion::orderBy('id_solicitud_produccion','desc')->get()->toArray();
        if($solicitudes){
            return $solicitudes;
        }else{
            return false;
        }

    }

    public function getCanDeliver(){
        $items = Capsule::select('select * from solicitud_almacen_materia_prima where id_solicitud_produccion = ?', [$this->id_solicitud_produccion]);
        $cant_solicitudes = count($items); 
        $items = Capsule::select('select * from solicitud_almacen_materia_prima where id_solicitud_produccion = ? and estatus = ?', [$this->id_solicitud_produccion, 1]);
        $cant_solicitudes_entregadas = count($items);
        if($cant_solicitudes_entregadas ==  $cant_solicitudes && $cant_solicitudes != 0){
            $display = 'inline';
        }else{
            $display = 'none';
        }
        return $display;
    }

    public function solicitudAlmacenProducto(){
        return $this->hasOne(SolicitudAlmacenProducto::class,'id_solicitud_almacen_producto','id_solicitud_almacen_producto');
    }
    public function producto(){
        return $this->hasOne(Producto::class,'id_producto','id_producto');
    }


    public function getEstatus(){
        return [
            "Solicitado"=>0,
            "Entregado"=>1,
        ];
    }
}
?>