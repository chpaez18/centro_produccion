<?php
use Application\Router;
use Application\TableComponent;

?>
<div class="card-box mb-30">
    <br>
	<div class="pb-20">
		<?php
			TableComponent::buildTable([
				'id'=>'almacenes-listado',
				'data'=>$dataProvider,
				'model'=>$almacen,
				'fields'=>[
					'nombre',
					'ubicacion',
				],
				"filter"=>true,
				'toolbar'=>[
					[
						'ruta'=>ROUTER::create_action_url("administracion/almacen/create"),
						'icono'=>'fas fa-plus-circle',
						'titulo'=>'Agregar Almacen'

					]
				],
				'buttons'=>[
					/*[
						'icono'=>'dw dw-eye',
						'titulo'=>'Ver',
						'action'=>'administracion/almacen/view'
					],*/
					[
						'icono'=>'dw dw-edit2',
						'titulo'=>'Modificar',
						'action'=>'administracion/almacen/update'
					],
					[
						'icono'=>'dw dw-delete-3',
						'titulo'=>'Eliminar',
						'action'=>'administracion/almacen/delete'
					],
				]
			]);
		?>
	</div>
</div>
