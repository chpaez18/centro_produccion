<?php
use Application\Router;
use Application\TableComponent;

?>
<div class="card-box mb-30">
    <br>
	<div class="pb-20">
		<?php
			TableComponent::buildTable([
				'id'=>'productos-listado',
				'data'=>$dataProvider,
				'model'=>$producto,
				'fields'=>[
					'nombre',
				],
				"filter"=>true,
				'toolbar'=>[
					[
						'ruta'=>ROUTER::create_action_url("administracion/producto/create"),
						'icono'=>'fas fa-plus-circle',
						'titulo'=>'Agregar Producto'

					]
				],
				'buttons'=>[
					[
						'icono'=>'dw dw-eye',
						'titulo'=>'Ver',
						'action'=>'administracion/producto/view'
					],
					[
						'icono'=>'dw dw-edit2',
						'titulo'=>'Modificar',
						'action'=>'administracion/producto/update'
					],
					[
						'icono'=>'dw dw-delete-3',
						'titulo'=>'Eliminar',
						'action'=>'administracion/producto/delete'
					],
				]
			]);
		?>
	</div>
</div>
