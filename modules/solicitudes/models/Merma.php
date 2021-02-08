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
class Merma extends Model
{
    protected $table = 'mermas';
    public $primaryKey = 'id_merma';
    public $timestamps = false;
    protected $fillable = [
        "id_producto", 
        "id_materia_prima", 
        "fecha_registro",
        "registrado_por",
        "cantidad_devuelta",
    ];

    public function getLabels(){
        return [
            "id_materia_prima" => "Materia Prima",
            "fecha_registro" => "Fecha",
            "registrado_por" => "Registrado Por",
            "cantidad_devuelta" => "Cantidad Devuelta",
        ];
    }

/*
    public function items(){
        return $this->hasMany(SolicitudAlmacenMateriaPrimaItems::class,'id_solicitud_almacen_materia_prima','id_solicitud_almacen_materia_prima');
    }
*/

}
?>