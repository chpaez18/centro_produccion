<?php 
 use Application\Router;

 $x = 0;
 $cant_productos = count($solicitud->solicitudCliente->productos);
 $cant_productos_faltantes =  $solicitud->getProductosFaltantes();

 if($cant_productos_faltantes ==  0){
     $show = true;
 }else{
     $show = false;
 }
 if($show and $solicitud->estatus != 1){
     $display = "inline";
 }else{
     $display = "none";
 }
 ?>
 <div class="pd-20 card-box mb-30">
    <div class="card card-box">
		<div class="card-header">
           <b>Información Solicitud: #0<?= $solicitud->id_solicitud_cliente." - ".$solicitud->solicitudCliente->cliente->nombre ?></b>
           <div style="float:right">
                <a style="display:<?= $display?>" href="<?= ROUTER::create_action_url("solicitudes/almacen/entregar",[$solicitud->id_solicitud_almacen_producto]) ?>" class="btn-sm btn-success"><i class="fas fa-check"></i> Entregar</a>
                <!-- <a style="display:<?php // $display?>" href="<?php // ROUTER::create_action_url("solicitudes/default/update",[$solicitud->id_solicitud_cliente]) ?>" class="btn-sm btn-primary"><i class="dw dw-edit2"></i> Modificar</a> -->
                <a style="display:<?= $display?>" id="delete_button" href="#" class="btn-sm btn-danger"><i class="dw dw-delete-3"></i></a>
           </div>
		</div>
		<div class="card-body">
            <div class="row">
                <div class="col-md-6">
                        <label for=""><b>Fecha Solicitud:</b></label>
                        <p><?=  date('d-m-Y', strtotime($solicitud->fecha_registro)) ?></p>
                </div>
                <div class="col-md-6" style="float:right">
                       
                        <label for=""> <b>Estatus</b> </label>
                        <p><?php    
                            switch ($solicitud->estatus) {
                                case 0:
                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-light'>Solicitado</span>";
                                    break;
                                case 1:
                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-success'>Entregado</span>";
                                break;
                            }
                            ?>
                        </p>
                </div>
                <div class="col-md-12">
                        <label for=""><b>Productos:</b></label>
                        <?php if($cant_productos >= 1){?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Cantidad Total</th>
                                            <th scope="col">Estatus Almacén</th>
                                            <th scope="col">Estatus Producción</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($x < $cant_productos) { ?>
                                        <tr>
                                            <th scope="row"><?= ($x == 0 ? '1':$x+1) ?></th>
                                            <td><?= $solicitud->solicitudCliente->productos[$x]->producto->nombre ?></td>
                                            <td><?= $solicitud->solicitudCliente->productos[$x]->cantidad ?></td>
                                            
                                            <td>
                                                <?php if ($solicitud->solicitudCliente->productos[$x]->estatus_almacen == 0){
                                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-light'>No Atendida</span>";
                                                }else if($solicitud->solicitudCliente->productos[$x]->estatus_almacen == 1){
                                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-info'>Solicitado</span>";
                                                }else if($solicitud->solicitudCliente->productos[$x]->estatus_almacen == 2){
                                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-success'>Entregado</span>";
                                                }
                                            ?>
                                            </td>
                                            <td>
                                                <?php if ($solicitud->solicitudCliente->productos[$x]->estatus_produccion == 0){
                                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-light'>No Atendida</span>";
                                                }else if($solicitud->solicitudCliente->productos[$x]->estatus_produccion == 1){
                                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-info'>Solicitado</span>";
                                                }else if($solicitud->solicitudCliente->productos[$x]->estatus_produccion == 2){
                                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-success'>Entregado</span>";
                                                }
                                            ?>
                                            </td>
                                            <?php if($solicitud->estatus != 1){ ?>
                                                <?php if($solicitud->solicitudCliente->productos[$x]->estatus_almacen == 1){ ?>
                                                    <td>
                                                        <?php if($solicitud->solicitudCliente->productos[$x]->estatus_produccion == 0 || $solicitud->solicitudCliente->productos[$x]->estatus_produccion == 2) {?>
                                                            <a href="<?= ROUTER::create_action_url("solicitudes/almacen/changeEstatusProducto", [$solicitud->solicitudCliente->productos[$x]->id_solicitud_cliente_item]) ?>" class="btn btn-sm btn-success"><i class="fas fa-check"></i></a>
                                                        <?php } ?>
                                                        
                                                        <!-- <a href="<?php // ROUTER::create_action_url("solicitudes/produccion/request", [$solicitud->solicitudCliente->productos[$x]->id_producto, $solicitud->id_solicitud_almacen_producto]) ?>" class="btn btn-sm btn-info"><i class="fas fa-external-link-alt"></i> Solicitar Producción</a> -->
                                                        <?php if($solicitud->solicitudCliente->productos[$x]->estatus_produccion == 0) {?>
                                                            <a href="#" id="solicitar-<?=$x?>" class="btn btn-sm btn-info" data-toggle="modal" data-target="#Medium-modal" type="button" cantidad-producto="<?= $solicitud->solicitudCliente->productos[$x]->cantidad ?>" nombre-producto="<?= $solicitud->solicitudCliente->productos[$x]->producto->nombre ?>" id-producto="<?= $solicitud->solicitudCliente->productos[$x]->id_producto ?>" solicitud-almacen-producto="<?= $solicitud->id_solicitud_almacen_producto ?>"> <i class="fas fa-external-link-alt"></i> Solicitar</a>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- modal de solicitud a produccion -->
                                                    <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myLargeModalLabel">Solicitud producción</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <label id="label"></label>
                                                                    <input name="cantidad" type="text" class="form-control form-control-lg" placeholder="Cantidad" id="cantidad-<?=$x?>">
                                                                    <input type="hidden" id="id_producto">
                                                                    <input type="hidden" id="solicitud_almacen_producto">
                                                                    <input type="hidden" id="input_cantidad">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <button type="button" class="btn btn-primary" id="boton_solicitar-<?=$x?>">Solicitar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- modal de solicitud a produccion -->
                                                    <script>
                                                            $(function(){
                                                                $('#solicitar-<?=$x?>').on('click', function () {

                                                                    var id_producto = $("#solicitar-<?=$x?>").attr( "id-producto" )
                                                                    var solicitud_almacen_producto = $("#solicitar-<?=$x?>").attr( "solicitud-almacen-producto" )
                                                                    var nombre_producto = $("#solicitar-<?=$x?>").attr( "nombre-producto" )
                                                                    var input_cant = $("#solicitar-<?=$x?>").attr("cantidad-producto")
                                                                    
                                                                    $('#id_producto').val(id_producto);
                                                                    $('#solicitud_almacen_producto').val(solicitud_almacen_producto);
                                                                    $('#input_cantidad').val(input_cant);
                                                                    $('#label').html("<b>"+nombre_producto+"</b>");
                                                                    window.variable = <?=$x?>
                                                                    
                                                                    
                                                                    
                                                                });

                                                                $("#boton_solicitar-<?=$x?>").on('click',function(){
                                                                    var id_producto = $("#solicitar-"+window.variable).attr( "id-producto" )
                                                                    var solicitud_almacen_producto = $("#solicitar-<?=$x?>").attr( "solicitud-almacen-producto" )
                                                                    var nombre_producto = $("#solicitar-"+window.variable).attr( "nombre-producto" )
                                                                    var cantidad  = $("#cantidad-<?=$x?>").val()
                                                                    var input_cant  = $("#input_cantidad").val()
                                                                //console.log(window.variable)
                                                                        //if(cantidad > input_cant){ //VERIFICAR ??
                                                                            //alert("La cantidad máxima a solicitar del producto es de: "+input_cant+", porfavor indíque un número igual o menor")
                                                                        //}else{
                                                                            $.ajax({
                                                                            type: "POST",
                                                                            url: "<?= ROUTER::create_action_url("solicitudes/produccion/request"); ?>",
                                                                            data: {data:{id_producto:id_producto, solicitud_almacen_producto:solicitud_almacen_producto, cantidad:cantidad}},
                                                                            success: function(data)          
                                                                            {   
                                                                                Swal.fire({
                                                                                    icon: 'success',
                                                                                    title: 'Solicitud registrada',
                                                                                    text: '',
                                                                                    footer: '',
                                                                                    showCloseButton: true,
                                                                                    confirmButtonColor: '#0275d8',
                                                                                    showCancelButton: false,
                                                                                    confirmButtonText: 'Ok',
                                                                                })
                                                                                .then(function (result) {
                                                                                    if (result.value) {
                                                                                        window.location.href = "<?= ROUTER::create_action_url("solicitudes/almacen/view",[$solicitud->id_solicitud_almacen_producto]); ?>";
                                                                                    }
                                                                                })
                                                                            }
                                                                            
                                                                            });
                                                                        //}
                                                                    
                                                                })
                                                            })

                                                    </script>
                                                <?php }else if($solicitud->solicitudCliente->productos[$x]->estatus_almacen == 2){ ?>
                                                    <td><a href="<?= ROUTER::create_action_url("solicitudes/almacen/changeEstatusProducto", [$solicitud->solicitudCliente->productos[$x]->id_solicitud_cliente_item]) ?>" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a></td>
                                                <?php } ?>
                                            <?php } ?>
                                        </tr>
                                    <?php $x++; } ?>

                                    </tbody>
                                </table>
                            </div>
                        <?php }else{
                            echo ' <br> Esta solicitud no cuenta con productos';
                        } ?>
                </div>

                <div class="col-md-12">
                    <label for=""><b>Observación:</b></label>
                    <p><?= $solicitud->observacion ?></p>
                </div>
            </div>
		</div>
	</div>
</div>






                    

<script>
$(document).ready(function(){
    $('#delete_button').on('click', function () {
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
                window.location.href='<?= ROUTER::create_action_url("solicitudes/almacen/delete",[$solicitud->id_solicitud_almacen_producto]) ?>';
            }
        })
    });


})
</script>