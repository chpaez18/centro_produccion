<?php
namespace Modules\administracion\models;
use \Illuminate\Database\Eloquent\Model;
use Application\ActiveRecord;
use Dflydev\DotAccessData\Data;
/**
* 
*/
class Materia extends Model
{
    protected $table = 'materias_primas';
    public $primaryKey = 'id_materia_prima';
    public $timestamps = false;
    protected $fillable = ["nombre", "unidad", "estatus"];


    public function getLabels(){
        return [
            "nombre" => "Nombre Materia Prima",
            "unidad" => "Unidad",
            "estatus" => "Estatus",
        ];
    }

    public function getMaterias(){
        //$clientes = Cliente::all()->toArray();
        $materias = Materia::where('estatus', '=', 1)->orderBy('id_materia_prima','desc')->get()->toArray();

        foreach ($materias as $key => $value) {
            $materias[$key]["nombre.unidad"] = $value["nombre"]."(".$value["unidad"].")";
        }
    
        if($materias){
            return $materias;
        }else{
            return false;
        }

    }

    public function getCustomName(){
        
        return $this->nombre;
    }
    
    
}
?>