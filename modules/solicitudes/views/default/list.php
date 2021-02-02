<?php
use Application\Router;
use Application\TableComponent;

?>
<div class="card-box mb-30">
    <br>
	<div class="pb-20">
		<?php
			TableComponent::buildTable([
				'id'=>'solicitudes-listado',
				'data'=>$dataProvider,
				'model'=>$solicitudes,
				'custom_code' => true,
				'fields'=>[
					//'id_cliente',
                    [
                        "campo"=>"fecha_registro",
                        "date_field" =>true,
                        "data"=>[
							"d-m-Y",
                        ]
					],
                    [
                        "campo"=>"id_cliente",
						"relational" =>true,
						"nameRelation"=>'cliente',
                        "data"=>[
                            'getCustomName'
                        ]
                    ],
                    [
                        "campo"=>"estatus",
                        "data"=>[
                            0=>"<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-light'>No Atendida</span></center>",
                            1=>"<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-info'>Atendida en Espera</span></center>",
                            2=>"<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-warning'>Por Entregar</span></center>",
                            3=>"<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-success'>Despachado</span></center>",
                            4=>"<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-danger'>Devuelto</span></center>",
                        ]
                    ]
				],
				"filter"=>true,
				'toolbar'=>[
					[
						'ruta'=>ROUTER::create_action_url("solicitudes/default/create"),
						'icono'=>'fas fa-plus-circle',
						'titulo'=>'Agregar Solicitud'

					]
				],
				'buttons'=>[
					[
						'icono'=>'dw dw-eye',
						'titulo'=>'Ver',
						'action'=>'solicitudes/default/view'
					],
					[
						'icono'=>'dw dw-edit2',
						'titulo'=>'Modificar',
						'action'=>'solicitudes/default/update'
					],
					[
						'icono'=>'dw dw-delete-3',
						'titulo'=>'Eliminar',
						'action'=>'solicitudes/default/delete'
					],
				]
			]);
		?>
	</div>
</div>
