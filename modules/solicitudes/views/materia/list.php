<?php
use Application\Router;
use Application\TableComponent;
use Modules\solicitudes\models\SolicitudAlmacenMateriaPrima;
use Modules\solicitudes\models\SolicitudCompras;
use Illuminate\Database\Capsule\Manager as Capsule;

?>
<div class="card-box mb-30">
    <br>
	<div class="pb-20">
	
					<div class="pb-20">
					<table class="solicitudes-materia-listado table stripe hover nowrap">
							<thead>
								<tr>
									<th>#</th>
									<th>Fecha Solicitud</th>
									<th>Materia Prima</th>
									<th>Cantidad</th>
									<th>Estatus</th>
									<th>Estatus Compra</th>
									<th class="datatable-nosort"></th>
								</tr>
							</thead>
							<thead class="row_filter">
								<tr>
									<th></th>
									<th>Fecha Solicitud</th>
									<th>Materia Prima</th>
									<th>Cantidad</th>
                                    <th>Estatus</th>
                                    <th>Estatus Compra</th>
                                    <th class="hidden-th"></th>
								</tr>
							</thead>
							<tbody>
                                <?php 
                                if(!empty($dataProvider)){
                                    foreach ($dataProvider as $key => $value) { 
									$solicitud = SolicitudAlmacenMateriaPrima::find($value["id_solicitud_almacen_materia_prima"]);
									

                                    if($key == 0){
										$key1 = $key+1;
									}else{
										$key1 = $key+1;
									}
								?>
								<tr>
									<td class="table-plus"><?= $key1 ?></td>
									<td><?= $solicitud->fecha_registro; ?></td>
									<td><?= $solicitud->materiaPrima->nombre; ?></td>
                                    <td>
                                        <?php   
                                            $data = Capsule::select('select * from productos_componentes where id_producto = ? and id_materia_prima = ?', [$solicitud->solicitudProduccion->id_producto, $solicitud->id_materia_prima]);
                                            $data2 = Capsule::select('select * from solicitud_compras where id_solicitud_almacen_materia_prima = ? and id_materia_prima = ?', [$value["id_solicitud_almacen_materia_prima"], $solicitud->materiaPrima->id_materia_prima]); 
                                            echo $data[0]->cantidad." (".$solicitud->materiaPrima->unidad.")";
                                            if($data2 != null){
                                                if($data2[0]->estatus == 0){
                                                    $visible = 0;
                                                }else if($data2[0]->estatus == 1){
                                                    $visible = 1;
                                                }else if ($data2[0]->estatus == 2){
                                                    $visible = 2;
                                                }
                                            }else{
                                                $visible = false;
                                            }
                                            
                                        ?>
                                    </td>
									<td><?= ($solicitud->estatus == 0 ? "<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-light'>Solicitado</span></center>":"<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-success'>Entregado</span></center>") ?></td>
                                    <td><?= (empty($data2) ? '-':($data2[0]->estatus  == 0 ? '<span class="badge badge-info">Solicitado a Compras</span>':($data2[0]->estatus  == 1 ? '<span class="badge badge-primary">Solicitado para comprar</span>':'<span class="badge badge-success">Entregado por compras</span>') )) ?></td>
                                    <td>
                                        <?php if($solicitud->estatus == 0){ ?>
                                                
                                                    <!-- validacion ocultar boton entregar cuando se solicito la materia prima a compras -->
                                                    <?php if(empty($data2) || $data2[0]->estatus != 0 ){ ?>
                                                        <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                    
                                                                    
                                                                    <!-- validacion ocultar boton comprar si ya se entrego la materia prima por parte de compras -->
                                                                    <?php if(empty($data2)){ ?>
                                                                        <a class="dropdown-item" href="<?=ROUTER::create_action_url("solicitudes/materia/deliver", [$value["id_materia_prima"], $value["id_solicitud_almacen_materia_prima"]])?>"><i class="fas fa-truck-loading"></i> Entregar</a>
                                                                        <a class="dropdown-item" href="#" id="btn_comprar-<?=$key?>" id-solicitud-materia="<?=$value["id_solicitud_almacen_materia_prima"]?>" id-materia-prima="<?=$value["id_materia_prima"]?>" cantidad="<?=$data[0]->cantidad?>" unidad="<?=$solicitud->materiaPrima->unidad?>" ><i class="fas fa-cash-register"></i> Comprar</a>

                                                                        <script>
                                                                            $("#btn_comprar-<?=$key?>").on('click', function(){
                                                                                var id_solicitud_almacen_materia_prima = $("#btn_comprar-<?=$key?>").attr( "id-solicitud-materia" )
                                                                                var id_materia_prima = $("#btn_comprar-<?=$key?>").attr( "id-materia-prima" )
                                                                                var cantidad = $("#btn_comprar-<?=$key?>").attr( "cantidad" )
                                                                                var unidad = $("#btn_comprar-<?=$key?>").attr( "unidad" )
                                                                                    $.ajax({
                                                                                            type: "POST",
                                                                                            url: "<?= ROUTER::create_action_url("solicitudes/materia/requestBuy"); ?>",
                                                                                            data: {data:{id_solicitud_almacen_materia_prima:id_solicitud_almacen_materia_prima, id_materia_prima:id_materia_prima, cantidad:cantidad, unidad:unidad}},
                                                                                            success: function(data)          
                                                                                            {   
                                                                                                Swal.fire({
                                                                                                    icon: 'success',
                                                                                                    title: 'Solicitud de compra registrada',
                                                                                                    text: '',
                                                                                                    footer: '',
                                                                                                    showCloseButton: true,
                                                                                                    confirmButtonColor: '#0275d8',
                                                                                                    showCancelButton: false,
                                                                                                    confirmButtonText: 'Ok',
                                                                                                })
                                                                                                .then(function (result) {
                                                                                                    if (result.value) {
                                                                                                        window.location.href = "<?= ROUTER::create_action_url("solicitudes/materia/list"); ?>";
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                    });
                                                                            })
                                                                        </script>
                                                                    <?php }else if($data2[0]->estatus  == 0) {  ?>

                                                                    <?php }else if ($data2[0]->estatus == 1){ ?>

                                                                    <?php }else if ($data2[0]->estatus == 2){ ?>
                                                                        <a class="dropdown-item" href="<?=ROUTER::create_action_url("solicitudes/materia/deliver", [$value["id_materia_prima"], $value["id_solicitud_almacen_materia_prima"]])?>"><i class="fas fa-truck-loading"></i> Entregar</a>

                                                                    <?php }else{ ?>
                                                                        <a class="dropdown-item" href="#" id="btn_comprar-<?=$key?>" id-solicitud-materia="<?=$value["id_solicitud_almacen_materia_prima"]?>" id-materia-prima="<?=$value["id_materia_prima"]?>" cantidad="<?=$data[0]->cantidad?>" unidad="<?=$solicitud->materiaPrima->unidad?>" ><i class="fas fa-cash-register"></i> Comprar</a>

                                                                        <script>
                                                                            $("#btn_comprar-<?=$key?>").on('click', function(){
                                                                                var id_solicitud_almacen_materia_prima = $("#btn_comprar-<?=$key?>").attr( "id-solicitud-materia" )
                                                                                var id_materia_prima = $("#btn_comprar-<?=$key?>").attr( "id-materia-prima" )
                                                                                var cantidad = $("#btn_comprar-<?=$key?>").attr( "cantidad" )
                                                                                var unidad = $("#btn_comprar-<?=$key?>").attr( "unidad" )
                                                                                    $.ajax({
                                                                                            type: "POST",
                                                                                            url: "<?= ROUTER::create_action_url("solicitudes/materia/requestBuy"); ?>",
                                                                                            data: {data:{id_solicitud_almacen_materia_prima:id_solicitud_almacen_materia_prima, id_materia_prima:id_materia_prima, cantidad:cantidad, unidad:unidad}},
                                                                                            success: function(data)          
                                                                                            {   
                                                                                                Swal.fire({
                                                                                                    icon: 'success',
                                                                                                    title: 'Solicitud de compra registrada',
                                                                                                    text: '',
                                                                                                    footer: '',
                                                                                                    showCloseButton: true,
                                                                                                    confirmButtonColor: '#0275d8',
                                                                                                    showCancelButton: false,
                                                                                                    confirmButtonText: 'Ok',
                                                                                                })
                                                                                                .then(function (result) {
                                                                                                    if (result.value) {
                                                                                                        window.location.href = "<?= ROUTER::create_action_url("solicitudes/materia/list"); ?>";
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                    });
                                                                            })
                                                                        </script>
                                                                    <?php } ?>
                                                                </div>
                                                        </div>
                                                    <?php } ?>
                                                
                                                
                                            
                                        <?php } ?>
									</td>
								</tr>
								<?php } ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				
	</div>
</div>




