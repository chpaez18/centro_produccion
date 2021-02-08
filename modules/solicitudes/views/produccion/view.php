<?php 
 use Application\Router;
 use Modules\solicitudes\models\SolicitudAlmacenMateriaPrima;
 use Illuminate\Database\Capsule\Manager as Capsule;
 $cant_components = count($solicitud->producto->componentes);
 $x = 0;
 $canDeliver = $solicitud->getCanDeliver();

 ?>
 <div class="pd-20 card-box mb-30">
    <div class="card card-box">
		<div class="card-header">
           <b>Información</b>
           <?php if($solicitud->estatus == 0){ ?>
           <div style="float:right">
                <a style="display:<?=$canDeliver?>" href="<?= ROUTER::create_action_url("solicitudes/produccion/entregarProducto",[$solicitud->id_solicitud_produccion, $solicitud->id_producto]) ?>" class="btn-sm btn-success"><i class="fas fa-check"></i> Entregar</a>
           </div>
           <?php } ?>
		</div>
		<div class="card-body">
            <div class="row">
                    <div class="col-md-3">
                        <label for=""><b>Solicitud Cliente:</b></label>
                        <p><?= $solicitud->solicitudAlmacenProducto->solicitudCliente->getCustomName() ?></p>
                    </div>
                    <div class="col-md-3">
                        <label for=""><b>Producto:</b></label>
                        <p><?= $solicitud->producto->nombre ?></p>
                    </div>
                    <div class="col-md-3">
                        <label for=""><b>Cantidad Solicitada:</b></label>
                        <p><?= $solicitud->cantidad ?></p>
                    </div>
                    <div class="col-md-3">
                    <label for=""> <b>Estatus Solicitud Producción</b> </label>
                        <p><?= ($solicitud->estatus == 0 ? '<span class="badge badge-info">Solicitado</span>':'<span class="badge badge-success">Entregado</span>') ?></p>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <div class="faq-wrap">
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header">
                                            <button class="btn btn-block collapsed" data-toggle="collapse" data-target="#faq1">
                                                Componentes del Producto
                                            </button>
                                        </div>
                                        <div id="faq1" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                            <?php if($cant_components >= 1){?>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Materia Prima</th>
                                                                <th scope="col">Cantidad</th>
                                                                <th scope="col">Estatus Solicitud Almacén</th>
                                                                <th scope="col">Acción</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php while ($x < $cant_components) {
                                                            $data = SolicitudAlmacenMateriaPrima::whereRaw('id_solicitud_produccion = ? and id_materia_prima = ?', [$solicitud->id_solicitud_produccion, $solicitud->producto->componentes[$x]->materia->id_materia_prima])->get()->toArray(); 
                                                        ?>
                                                            <tr>
                                                                <th scope="row"><?= ($x == 0 ? '1':$x+1) ?></th>
                                                                <td><?= $solicitud->producto->componentes[$x]->materia->nombre." (".$solicitud->producto->componentes[$x]->materia->unidad.")" ?></td>
                                                                <td><?= $solicitud->producto->componentes[$x]->cantidad ?></td>
                                                                <td><?= (empty($data ) ? '-':($data[0]["estatus"]  == 0 ? '<span class="badge badge-info">Solicitado</span>':'<span class="badge badge-success">Entregado</span>')) ?></td>
                                                                <td> 
                                                                    <?php if(empty($data) ){         
                                                                    ?>
                                                                    <?php if($solicitud->estatus != 1 ){ ?>
                                                                        <a href="<?=ROUTER::create_action_url("solicitudes/produccion/requestAlmacen",[$solicitud->id_solicitud_produccion, $solicitud->producto->componentes[$x]->materia->id_materia_prima])?>" class="btn btn-sm btn-info" type="button" > <i class="fas fa-external-link-alt"></i> Solicitar</a> 
                                                                    <?php } ?>
                                                                        
                                                                    <?php }else if($data[0]["estatus"] == 0 ){} ?>
                                                                </td>
                                                                <td>
                                                                <?php if($data[0]["estatus"] == 1) {?>
                                                                    <a href="#" id="merma-<?=$x?>" class="btn btn-sm btn-info" data-toggle="modal" data-target="#Medium-modal" type="button" cantidad-solicitud="<?= $solicitud->producto->componentes[$x]->cantidad?>"  id-materia-prima="<?= $solicitud->producto->componentes[$x]->materia->id_materia_prima ?>" id-producto="<?= $solicitud->producto->id_producto ?>"> <i class="fas fa-external-link-alt"></i> Merma</a>
                                                                <?php } ?>
                                                                </td>
                                                    <!-- modal de mermas -->
                                                    <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myLargeModalLabel">Mermas</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <label id="label"><b>Porfavor, indique la cantidad total que utilizo de esta materia prima</b></label>
                                                                    <input name="cantidad" type="text" class="form-control form-control-lg" placeholder="Cantidad" id="cantidad-<?=$x?>">
                                                                    <input type="hidden" id="id_materia_prima">
                                                                    <input type="hidden" id="input_cantidad">
                                                                    <input type="hidden" id="id_producto">
                                                                    <input type="hidden" id="cantidad_solicitud">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <button type="button" class="btn btn-primary" id="boton_guardar-<?=$x?>">Guardar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- modal de mermas -->
                                                    <script>
                                                        $(function(){
                                                            $('#merma-<?=$x?>').on('click', function(){
                                                                var id_materia_prima = $("#merma-<?=$x?>").attr( "id-materia-prima" )
                                                                var id_producto = $("#merma-<?=$x?>").attr( "id-producto" )
                                                                var cantidad_solicitud = $("#merma-<?=$x?>").attr( "cantidad-solicitud" )
                                                                var cantidad = $("#cantidad-<?=$x?>").val()
                                                                $('#id_materia_prima').val(id_materia_prima);
                                                                $('#input_cantidad').val(cantidad);
                                                                $('#id_producto').val(id_producto);
                                                                $('#cantidad_solicitud').val(cantidad_solicitud);
                                                                window.variable2 = <?=$x?>

                                                            })
                                                            $('#boton_guardar-<?=$x?>').on('click', function(){
                                                                var id_materia_prima  = $("#id_materia_prima").val()
                                                                var id_producto  = $("#id_producto").val()
                                                                var cantidad  = $("#cantidad-<?=$x?>").val()
                                                                var cantidad_solicitud  = $("#cantidad_solicitud").val()

                                                                $.ajax({
                                                                type: "POST",
                                                                url: "<?= ROUTER::create_action_url("solicitudes/produccion/merma"); ?>",
                                                                data: {data:{id_materia_prima:id_materia_prima, cantidad:cantidad, id_producto:id_producto, cantidad_solicitud:cantidad_solicitud}},
                                                                success: function(data)          
                                                                {   
                                                                    Swal.fire({
                                                                        icon: 'success',
                                                                        title: 'Merma actualizada para esta materia prima',
                                                                        text: '',
                                                                        footer: '',
                                                                        showCloseButton: true,
                                                                        confirmButtonColor: '#0275d8',
                                                                        showCancelButton: false,
                                                                        confirmButtonText: 'Ok',
                                                                    })
                                                                    .then(function (result) {
                                                                        if (result.value) {
                                                                            window.location.href = "<?= ROUTER::create_action_url("solicitudes/produccion/view",[$solicitud->id_solicitud_almacen_producto]); ?>";
                                                                        }
                                                                    })
                                                                }
                                                                });
                                                            })
                                                        })
                                                    </script>
                                                            </tr>
                                                        <?php $x++; } ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php }else{
                                                echo ' <br> Este producto no cuenta con componentes';
                                            } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
		</div>
	</div>
</div>
