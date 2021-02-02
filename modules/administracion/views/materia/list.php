<?php
use Application\Router;
use Application\TableComponent;

?>
<div class="card-box mb-30">
    <br>
	<div class="pb-20">
		<?php
			TableComponent::buildTable([
				'id'=>'materias-listado',
				'data'=>$dataProvider,
				'model'=>$materia,
				'fields'=>[
					'nombre',
					'unidad',
                    [
                        "campo"=>"estatus",
                        "data"=>[
                            0=>"<span class='badge badge-danger'>No Disponible</span>",
                            1=>"<span class='badge badge-success'>Disponible</span>"
                        ]
                    ]
				],
				"filter"=>true,
				'toolbar'=>[
					[
						'ruta'=>ROUTER::create_action_url("administracion/materia/create"),
						'icono'=>'fas fa-plus-circle',
						'titulo'=>'Agregar Materia Prima'

					]
				],
				'buttons'=>[
					/*[
						'icono'=>'dw dw-eye',
						'titulo'=>'Ver',
						'action'=>'administracion/materia/view'
					],*/
					[
						'icono'=>'dw dw-edit2',
						'titulo'=>'Modificar',
						'action'=>'administracion/materia/update'
					],
					[
						'icono'=>'dw dw-delete-3',
						'titulo'=>'Eliminar',
						'action'=>'administracion/materia/delete'
					],
				]
			]);
		?>
	</div>
</div>
