<?php
namespace Modules\administracion\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
/**
* 
*/
class Cliente extends Model
{
    protected $table = 'clientes';
    public $primaryKey = 'id_cliente';
    public $timestamps = false;
    protected $fillable = ["id_cliente","alias", "nombre",'tipo','rif','telefono','email','website','contacto','telefono_contacto','email_contacto','direccion'];

    public function getLabels(){
        return [
            "alias" => "Alías",
            "nombre" => "Nombre del Cliente",
            "rif" => "Rif",
            "email" => "Correo Eléctronico",
        ];
    }

    public function getClientes(){
        //$clientes = Cliente::all()->toArray();
        $clientes =Cliente::orderBy('id_cliente','desc')->get()->toArray();
        
        if($clientes){
            return $clientes;
        }else{
            return false;
        }

    }

    public function getCustomName(){
        
        return $this->nombre;
    }
}
?>