<?php
use Application\Router;
use Application\TableComponent;
use Modules\administracion\models\Inventario;

?>
<div class="card-box mb-30">
    <br>
	<div class="pb-20">
	
					<div class="pb-20">
					<table class="inventario-listado table stripe hover nowrap">
						<div class="toolbar">
							<div class="btn-group mb-15">
								<a href="<?=ROUTER::create_action_url("administracion/inventario/create")?>" class="btn-sm btn-light"><i class="fas fa-plus-circle"></i> Agregar Inventario</a> 

							</div>
        				</div>
							<thead>
								<tr>
									<th>#</th>
									<th>Tipo</th>
									<th>Nombre</th>
									<th>Disponible</th>
									<th>Estatus</th>
									<th class="datatable-nosort"></th>
								</tr>
							</thead>
							<thead class="row_filter">
								<tr>
									<th></th>
									<th>Tipo</th>
									<th>Nombre</th>
									<th>Disponible</th>
									<th>Estatus</th>
									<th class="hidden-th"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($dataProvider as $key => $value) { 
									$inventario = Inventario::find($value["id_inventario"]);
									
									if($key == 0){
										$key = $key+1;
									}else{
										$key = $key+1;
									}
								?>
								<tr>
									<td class="table-plus"><?= $key ?></td>
									<!-- <td><?php //$inventario->almacen->nombre ?></td> -->
									<td><?= ($inventario->tipo == 0 ? 'MP':'PT') ?></td>
									<td><?= (isset($inventario->id_producto) ? $inventario->producto->nombre:(isset($inventario->id_materia_prima) ? $inventario->materia->nombre: 'N/A'  )  ) ?></td>
									<td><?= $value["cantidad"]." ".(isset($inventario->id_materia_prima) ? $inventario->materia->unidad: 'UN' ) ?></td>
									<td><?= ($inventario->estatus == 0 ? '<span class="badge badge-danger">No Disponible</span>':'<span class="badge badge-success">Disponible</span>') ?></td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<!-- <a class="dropdown-item" href="<?php //ROUTER::create_action_url("administracion/inventario/view", [$value["id_inventario"]])?>"><i class="dw dw-eye"></i> Ver</a> -->
												<a class="dropdown-item" href="<?=ROUTER::create_action_url("administracion/inventario/update", [$value["id_inventario"]])?>"><i class="dw dw-edit2"></i> Modificar</a>
												<a class="dropdown-item" href="#" id="delete-<?= $value["id_inventario"] ?>"><i class="dw dw-delete-3"></i> Eliminar</a>
												<script>
													$(document).ready(function(){
														$('.inventario-listado').on('click', '#delete-<?= $value["id_inventario"] ?>', function () {
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
																	window.location.href='<?=ROUTER::create_action_url("administracion/inventario/delete", [$value["id_inventario"]])?>';
																}
															})
														});
													})
												</script>

											</div>
										</div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				
	</div>
</div>




