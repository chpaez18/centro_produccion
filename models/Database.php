<?php
namespace Models; 
use Illuminate\Database\Capsule\Manager as Capsule;

class Database {
    public $db; 

    function __construct() {

        if(ENVIROMENT === "local"){
            $capsule = new Capsule;
            $capsule->addConnection([
             'driver' => 'mysql',
             'host' => 'localhost',
             'database' => 'control',
             'username' => 'root',
             'password' => 'importmotor#',
             'charset' => 'utf8',
             'collation' => 'utf8_unicode_ci',
             'prefix' => '',
            ]);
            // Setup the Eloquent ORM… 
            $capsule->setAsGlobal();
            $capsule->bootEloquent();

        }elseif(ENVIROMENT === "server"){
            $capsule = new Capsule;
            $capsule->addConnection([
             'driver' => 'mysql',
             'host' => 'localhost',
             'database' => 'prueba_tecnica',
             'username' => 'root',
             'password' => 'importmotor#',
             'charset' => 'utf8',
             'collation' => 'utf8_unicode_ci',
             'prefix' => '',
            ]);
            // Setup the Eloquent ORM… 
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
        }

        //auto construimos dinamicamente los atributos de la clase que se esta instanciando, de tal forma de tener disponible en un simple objeto el valor que se recoge por el formulario 
        foreach ($_POST as $key => $value) {

            if(is_array($value)){
                //echo "esto es un array";
            }else{
                $this->$key = "$value";
            }
        }

    }
 
}
?>