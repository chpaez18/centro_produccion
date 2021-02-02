<?php
use Application\Router;
use Application\TableComponent;

?>
<div class="card-box mb-30">
    <br>
	<div class="pb-20">
		<?php
			TableComponent::buildTable([
				'id'=>'solicitudes-produccion-listado',
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
                    /*[
                        "campo"=>"id_solicitud_almacen_producto",
                        "relational" =>true,
                        "nameRelation"=>'solicitudAlmacenProducto',
                        "data"=>[
                            'getCustomName'
                        ]
                    ],*/
                    [
                        "campo"=>"id_producto",
                        "relational" =>true,
                        "nameRelation"=>'producto',
                        "data"=>[
                            'getCustomName'
                        ]
                    ],
                    [
                        "campo"=>"estatus",
                        "data"=>[
                            0=>"<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-light'>Solicitado</span></center>",
                            1=>"<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-success'>Entregado</span></center>",
                        ]
                    ]
				],
				"filter"=>true,
				'toolbar'=>[
					/*[
						'ruta'=>ROUTER::create_action_url("solicitudes/almacen/create"),
						'icono'=>'fas fa-plus-circle',
						'titulo'=>'Agregar Solicitud',
						'visible'=>$solicitudCliente->getSolicitudesNoAtendidas()

					]*/
				],
				'buttons'=>[
					[
						'icono'=>'dw dw-eye',
						'titulo'=>'Ver',
						'action'=>'solicitudes/produccion/view',
					],
					/*[
						'icono'=>'dw dw-edit2',
						'titulo'=>'Modificar',
						'action'=>'solicitudes/almacen/update'
					],*/
					/*[
						'icono'=>'dw dw-delete-3',
						'titulo'=>'Eliminar',
						'action'=>'solicitudes/almacen/delete'
					],*/
				]
			]);
		?>
	</div>
</div>
