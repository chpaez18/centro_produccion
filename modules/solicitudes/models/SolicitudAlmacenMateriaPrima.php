<?php
namespace Modules\solicitudes\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
use Application\Utilities;
use Modules\administracion\models\Materia;
use Modules\administracion\models\ProductoComponente;

/**
* 
*/
class SolicitudAlmacenMateriaPrima extends Model
{
    protected $table = 'solicitud_almacen_materia_prima';
    public $primaryKey = 'id_solicitud_almacen_materia_prima';
    public $timestamps = false;
    protected $fillable = [
        "id_solicitud_produccion", 
        "id_materia_prima", 
        "fecha_registro",
        "estatus",
        "solicitado_por",
        "entregado_por",
    ];
    public $cantidad;

    public function getLabels(){
        return [
            "id_solicitud_produccion" => "Solicitud Produccion",
            "id_materia_prima" => "Materia Prima",
            "cantidad" => "Cantidad",
            "estatus" => "Estatus",
            "fecha_registro" => "Fecha Solicitud",
            "solicitado_por" => "Solicitado Por",
            "entregado_por" => "Entregado Por",
        ];
    }
    
    public function getSolicitudesAlmacenMateriaPrima(){
        //$clientes = Cliente::all()->toArray();
        $solicitudes = SolicitudAlmacenMateriaPrima::orderBy('id_solicitud_almacen_materia_prima','desc')->get()->toArray();
        if($solicitudes){
            return $solicitudes;
        }else{
            return false;
        }

    }

    public function solicitudProduccion(){
        return $this->hasOne(SolicitudProduccion::class,'id_solicitud_produccion','id_solicitud_produccion');
    }
    public function materiaPrima(){
        return $this->hasOne(Materia::class,'id_materia_prima','id_materia_prima');
    }
    public function productoComponente(){
        return $this->hasOne(ProductoComponente::class,'id_materia_prima','id_materia_prima');
    }

/*
    public function items(){
        return $this->hasMany(SolicitudAlmacenMateriaPrimaItems::class,'id_solicitud_almacen_materia_prima','id_solicitud_almacen_materia_prima');
    }
*/

    public function getEstatus(){
        return [
            "Solicitado"=>0,
            "Entregado"=>1,
        ];
    }
}
?>