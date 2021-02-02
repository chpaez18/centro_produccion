<?php
namespace Modules\solicitudes\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
use Application\Utilities;
use Modules\administracion\models\Materia;
use Modules\solicitudes\models\SolicitudAlmacenMateriaPrima;
use Illuminate\Database\Capsule\Manager as Capsule;
/**
* 
*/
class SolicitudCompras extends Model
{
    protected $table = 'solicitud_compras';
    public $primaryKey = 'id_solicitud_compra';
    public $timestamps = false;
    protected $fillable = [
        "id_materia_prima", 
        "id_solicitud_almacen_materia_prima", 
        "fecha_registro",
        "cantidad",
        "unidad",
        "estatus",
        "solicitado_por",
        "entregado_por",
    ];

    public function getLabels(){
        return [
            "id_materia_prima" => "Materia Prima",
            "id_solicitud_almacen_materia_prima" => "Solicitud Materia Prima",
            "fecha_registro" => "Fecha Solicitud",
            "cantidad" => "Cantidad",
            "estatus" => "Estatus",
            "solicitado_por" => "Solicitado Por",
            "entregado_por" => "Entregado Por",
        ];
    }
    
    public function getSolicitudesCompras(){
        //$clientes = Cliente::all()->toArray();
        $solicitudes = SolicitudCompras::orderBy('id_solicitud_compra','desc')->get()->toArray();
        if($solicitudes){
            return $solicitudes;
        }else{
            return false;
        }

    }
   

    public function solicitudAlmacenMateriaPrima(){
        return $this->hasOne(SolicitudAlmacenMateriaPrima::class,'id_solicitud_almacen_materia_prima','id_solicitud_almacen_materia_prima');
    }
    public function materiaPrima(){
        return $this->hasOne(Materia::class,'id_materia_prima','id_materia_prima');
    }

    public function getSolicitudesFaltantes(){
        $items = Capsule::select('select * from solicitud_compras where id_materia_prima = ? and id_solicitud_almacen_materia_prima = ? and estatus = ?', [$this->id_materia_prima, $this->id_solicitud_almacen_materia_prima, 1]);
        return count($items);
    }

    public function getEstatus(){
        return [
            "Solicitado"=>0,
            "Entregado"=>1,
        ];
    }
}
?>