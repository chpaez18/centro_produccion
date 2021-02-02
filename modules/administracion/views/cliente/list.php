<?php
use Application\Router;
use Application\TableComponent;

?>

<div class="card-box mb-30">
    <br>
	<div class="pb-20">
		<?php
			TableComponent::buildTable([
				'id'=>'clientes-listado',
				'data'=>$dataProvider,
				'model'=>$cliente,
				'fields'=>[
					'alias',
					'nombre',
					'rif',
					'email'
				],
				"filter"=>true,
				'toolbar'=>[
					[
						'ruta'=>ROUTER::create_action_url("administracion/cliente/create"),
						'icono'=>'fas fa-plus-circle',
						'titulo'=>'Agregar Cliente'

					]
				],
				'buttons'=>[
					[
						'icono'=>'dw dw-eye',
						'titulo'=>'Ver',
						'action'=>'administracion/cliente/view'
					],
					[
						'icono'=>'dw dw-edit2',
						'titulo'=>'Modificar',
						'action'=>'administracion/cliente/update'
					],
					[
						'icono'=>'dw dw-delete-3',
						'titulo'=>'Eliminar',
						'action'=>'administracion/cliente/delete'
					],
				]
			]);
		?>
	</div>
</div>












