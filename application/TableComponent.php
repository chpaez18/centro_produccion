<?php
namespace Application;
use Modules\administracion\models\Almacen;
class TableComponent
{
	
	static function buildTable($context) {

        $table = '<table class="'.$context["id"].' table stripe hover nowrap">';

        //TOOLBAR
        $table .=   '<div class="toolbar">';
        $table .=   '<div class="btn-group mb-15">';
        foreach($context["toolbar"] as $key => $value){
            if(isset($value["visible"])){
                $table .=   '<a style=" display:'.($value["visible"] ? 'inline':'none' ).'" href="'.$value["ruta"].'" class="btn-sm btn-light"><i class="'.$value["icono"].'"></i> '.$value["titulo"].'</a>'; 
            }else{
                $table .=   '<a href="'.$value["ruta"].'" class="btn-sm btn-light"><i class="'.$value["icono"].'"></i> '.$value["titulo"].'</a>'; 
            }
            
        
        }
        $table .=   '</div>';
        $table .=   '</div>';

        //THEAD FIELDS
        $table .=   '<thead>';
        $table .=   '<tr>';
        $table .=   '<th>#</th>';
        
        foreach($context["fields"] as $key => $value){
            //var_dump($context["model"]);
            
            if(is_array($value)){
                
                $table .= '<th>'.$context["model"]->getLabels()[$value["campo"]].'</th>';
          
            }else{
                $name = explode('.',$value);
                if(count($name) > 1){
                    $table .=   '<th>'.$context["model"]->getLabels()[$value].'</th>';
                    //var_dump($name);die();
                }else{
                    $table .=   '<th>'.$context["model"]->getLabels()[$value].'</th>';
                }
            }
             
        }
		$table .= '<th class="datatable-nosort"></th>'; 
        $table .= '</tr>';
        

        $table .= '</thead>'; 
        
        if($context["filter"]){
            $table .= '<thead class="row_filter">';
            $table .=  '<tr>';
            $table .= '<th></th>';
            foreach($context["fields"] as $key3 => $value3){
                //var_dump($context["model"]);
                
                if(is_array($value3)){
                    
                    $table .= '<th>'.$context["model"]->getLabels()[$value3["campo"]].'</th>';
              
                }else{
                    $name = explode('.',$value3);
                    if(count($name) > 1){
                        $table .=   '<th>'.$context["model"]->getLabels()[$value3].'</th>';
                        //var_dump($name);die();
                    }else{
                        $table .=   '<th>'.$context["model"]->getLabels()[$value3].'</th>';
                    }
                }
                 
            }
            $table .= '<th class="hidden-th"></th>';
            $table .= '</tr>';
            $table .= '</thead>';
        }

        //TBODY DATA
        $table .= '<tbody>'; 

        // $table .= '<th></th>';
        // foreach($context["fields"] as $key3 => $value3){
        //     //var_dump($context["model"]);
            
        //     if(is_array($value3)){
                
        //         $table .= '<th>'.$context["model"]->getLabels()[$value3["campo"]].'</th>';
          
        //     }else{
        //         $name = explode('.',$value3);
        //         if(count($name) > 1){
        //             $table .=   '<th>'.$context["model"]->getLabels()[$value3].'</th>';
        //             //var_dump($name);die();
        //         }else{
        //             $table .=   '<th>'.$context["model"]->getLabels()[$value3].'</th>';
        //         }
        //     }
             
        // }
        // $table .= '<th class="hidden-th"></th>';
        if($context["data"]){
            $cont = count($context["data"]);
            foreach ($context["data"] as $key => $value) {

            $table .= '<tr>';
            
            // if($key == 0){
            //     $key = $key+1;
            // }else{
            //     $key = $key+1;
            // }
            
            if(isset($context["custom_code"])){
                $table .= '<td>0'.$cont.'</td>';
            }else{
                $table .= '<td>'.$cont.'</td>';
            }
            
            $cont = $cont-1;
            foreach ($context["fields"] as $key1 => $value1) {
                if(is_array($value1)){
                    //var_dump(isset($value1["date_field"]));die();
                    if(array_key_exists('relational',$value1)){
                        $id = array_values($context["data"][$key])[0];
                        $aux0 = $value1["data"][0];
                        $nameRelation = $value1["nameRelation"];
                        $aux = $context["model"]::find($id)->$nameRelation->$aux0();
                        $table .= '<td>'.$aux.'</td>';
                    }else if(array_key_exists('date_field',$value1)){
                        $table .=  '<td>'.date($value1["data"][0], strtotime($value[$value1["campo"]])).'</td>';
                    }else{
                        $table .=  '<td>'.$value1["data"][$value[$value1["campo"]]].'</td>';
                    }
                    
                    
                }else{
                    $name = explode('.',$value1);
                    //var_dump($value1);die();
                    if(count($name) > 1){
                        $table .=  '<td>'.$value[$name[0]][$name[1]] .'</td>';
                        //var_dump($value[$name[0]][$name[1]]);
                    }else{
                        
                        $table .= (isset($value[$value1]) ? '<td>'.$value[$value1].'</td>':'<td>N/D</td>'); 
                        
                    }
                }

                
                //$table .= '<td>'.$value[$value1].'</td>';
                
            }

            //BUTTONS
            $table .="<td>";
            $table .="<div class='dropdown'>";
            $table .="<a class='btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle' href='#' role='button' data-toggle='dropdown'>";
            $table .="<i class='dw dw-more'></i>";
            $table .="</a>";

            $table .="<div class='dropdown-menu dropdown-menu-right dropdown-menu-icon-list'>";
            foreach($context["buttons"] as $key1 => $value1){
                
                $action = explode("/", $value1['action']);
                if($action[2] == "delete"){
                    $table .=   '<a href="#" id="delete-'.$value[$context["model"]->primaryKey].'" class="dropdown-item" ><i class="'.$value1["icono"].'"></i>'.$value1["titulo"].'</a>'; 
                    $id = $value[$context["model"]->primaryKey];
                    $table .= "<script>";
                    $table .= "$(document).ready(function(){
                        $('.".$context["id"]."').on('click', '#delete-".$id."', function () {
                            Swal.fire({
                                icon: 'warning',
                                title: '¿Está Seguro de querer eliminar este registro?',
                                text: '',
                                footer: '',
                                showCloseButton: true,
                                confirmButtonColor: '#0275d8',
                                showCancelButton: true,
                                confirmButtonText: 'Si',
                                cancelButtonText: 'Cancelar',
                                cancelButtonColor: '#d9534f',
                            })
                            .then(function (result) {
                                if (result.value) {
                                    window.location.href='".ROUTER::create_action_url($value1['action'], [$value[$context["model"]->primaryKey]])."';
                                }
                            })
                        });
                    })
                    ";
                    $table .= "</script>";
                }else{
                    if(isset($value1['data'])){
                        $table .=   '<a class="dropdown-item" href="'.ROUTER::create_action_url($value1['action'], [$value[$value1['data']]]).'"><i class="'.$value1["icono"].'"></i>'.$value1["titulo"].'</a>'; 
                    }else{
                        $table .=   '<a class="dropdown-item" href="'.ROUTER::create_action_url($value1['action'], [$value[$context["model"]->primaryKey]]).'"><i class="'.$value1["icono"].'"></i>'.$value1["titulo"].'</a>'; 
                    }
                    
                }
            }
            $table .="</div>";
            $table .="</div>";
            $table .="</td>";
            //BUTTONS

            $table .= '</tr>';
        }
        }

        $table .= '</tbody>'; 
        //TBODY DATA



		$table .= '</table>';
		echo $table;
	}	


    
}

?>