<?php
namespace Modules\solicitudes\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
use Modules\administracion\models\Cliente;
use Illuminate\Database\Capsule\Manager as Capsule;
/**
* 
*/
class SolicitudAlmacenProducto extends Model
{
    protected $table = 'solicitud_almacen_producto';
    public $primaryKey = 'id_solicitud_almacen_producto';
    public $timestamps = false;
    protected $fillable = [
        "id_solicitud_cliente", 
        "fecha_registro",
        "fecha_recepcion",
        "estatus",
        "solicitado_por",
        "entregado_por",
    ];

    public function getLabels(){
        return [
            "fecha_registro" => "Fecha Solicitud",
            "fecha_recepcion" => "Fecha de Recepción",
            "estatus" => "Estatus",
            "solicitado_por" => "Solicitado Por",
            "id_solicitud_cliente" => "Solicitud Cliente",
            "id_solicitud_almacen_producto" => "Solicitud Cliente",
        ];
    }
    
    public function getSolicitudesAlmacenProducto(){
        //$clientes = Cliente::all()->toArray();
        $solicitudes = SolicitudAlmacenProducto::orderBy('id_solicitud_almacen_producto','desc')->get()->toArray();
        if($solicitudes){
            return $solicitudes;
        }else{
            return false;
        }

    }

    public function getProductosFaltantes(){
        $items = Capsule::select('select * from solicitud_clientes_items where id_solicitud_cliente = ? and estatus_almacen = ?', [$this->id_solicitud_cliente, 1]);
        return count($items);
    }

    public function solicitudCliente(){
        return $this->hasOne(SolicitudCliente::class,'id_solicitud_cliente','id_solicitud_cliente');
    }

/*
    public function productos(){
        return $this->hasMany(SolicitudClienteItems::class,'id_solicitud_cliente','id_solicitud_cliente');
    }
*/
    public function getCustomName(){
            
        return "0".$this->solicitudCliente->id_solicitud_cliente." - ".$this->solicitudCliente->cliente->nombre;
    }
    public function getEstatus(){
        return [
            "Solicitado"=>0,
            "Entregado"=>1,
        ];
    }
}
?>