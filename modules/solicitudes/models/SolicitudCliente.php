<?php
namespace Modules\solicitudes\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
use Application\Utilities;
use Modules\administracion\models\Cliente;
/**
* 
*/
class SolicitudCliente extends Model
{
    protected $table = 'solicitud_clientes';
    public $primaryKey = 'id_solicitud_cliente';
    public $timestamps = false;
    protected $fillable = [
        "id_cliente", 
        "fecha_registro",
        "estatus",
        "observacion",
    ];

    public function getLabels(){
        return [
            "fecha_registro" => "Fecha Registro",
            "id_cliente" => "Cliente",
            "estatus" => "Estatus",
            "observacion" => "Observación",
        ];
    }
    
    public function getSolicitudesClientes(){
        //$clientes = Cliente::all()->toArray();
        $solicitudes = SolicitudCliente::orderBy('id_solicitud_cliente','desc')->get()->toArray();
        if($solicitudes){
            return $solicitudes;
        }else{
            return false;
        }

    }
    public function getSolicitudesNoAtendidas(){
        //$clientes = Cliente::all()->toArray();
        $solicitudes = SolicitudCliente::where('estatus',0)->orderBy('id_solicitud_cliente','desc')->get()->toArray();
        
        if($solicitudes){
            $data =  Utilities::buildRelation(new SolicitudCliente,['cliente'],$solicitudes,"All",'hasMany',['cliente']);
            return $data;
        }else{
            return false;
        }

    }

    public function cliente(){
        return $this->hasOne(Cliente::class,'id_cliente','id_cliente');
    }
    public function productos(){
        return $this->hasMany(SolicitudClienteItems::class,'id_solicitud_cliente','id_solicitud_cliente');
    }

    public function getCustomName(){
        
        return "0".$this->id_solicitud_cliente." - ".$this->cliente->nombre;
    }

    public function getEstatus(){
        return [
            "No atendida"=>0,
            "Atendida en Espera"=>1,
            "Por entregar"=>2,
            "Despachado"=>3,
            "Devuelto"=>4,
        ];
    }
}
?>