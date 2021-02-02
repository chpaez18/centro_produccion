<?php 
 use Application\Router;

 $x = 0;
 $cant_productos = count($solicitud->productos);
 
 ?>
 <div class="pd-20 card-box mb-30">
    <div class="card card-box">
		<div class="card-header">
           <b>Información Solicitud: #0<?= $solicitud->id_solicitud_cliente ?></b>
           <div style="float:right">
                <a href="<?= ROUTER::create_action_url("solicitudes/default/update",[$solicitud->id_solicitud_cliente]) ?>" class="btn-sm btn-primary"><i class="dw dw-edit2"></i> Modificar</a>
                <a id="delete_button" href="#" class="btn-sm btn-danger"><i class="dw dw-delete-3"></i></a>
           </div>
		</div>
		<div class="card-body">
            <div class="row">
                <div class="col-md-6">
                        <label for=""><b>Cliente:</b></label>
                        <p><?= $solicitud->cliente->nombre ?></p>
                        <br>
                        <label for=""> <b>Estatus</b> </label>
                        <p><?php    
                            switch ($solicitud->estatus) {
                                case 0:
                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-light'>No Atendida</span>";
                                    break;
                                case 1:
                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-info'>Atendida en Espera</span>";
                                break;
                                case 2:
                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-warning'>Por Entregar</span>";
                                break;
                                case 3:
                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-success'>Despachado</span>";
                                break;
                                case 4:
                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-danger'>Devuelto</span>";
                                break;
                            }
                            ?>
                        </p>
                </div>
                <div class="col-md-6">
                        <label for=""><b>Productos:</b></label>
                        <?php if($cant_productos >= 1){?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Estatus Almacén</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($x < $cant_productos) { ?>
                                        <tr>
                                            <th scope="row"><?= ($x == 0 ? '1':$x+1) ?></th>
                                            <td><?= $solicitud->productos[$x]->producto->nombre ?></td>
                                            <td><?= $solicitud->productos[$x]->cantidad ?></td>
                                            <td>
                                                <?php if ($solicitud->productos[$x]->estatus_almacen == 0){
                                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-light'>No Atendida</span>";
                                                }else if($solicitud->productos[$x]->estatus_almacen == 1){
                                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-info'>Solicitado</span>";
                                                }else if($solicitud->productos[$x]->estatus_almacen == 2){
                                                    echo "<span style='font-size:13px;text-transform: uppercase' class='badge badge-success'>Entregado</span>";
                                                }
                                            ?>
                                            </td>
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
                window.location.href='<?= ROUTER::create_action_url("administracion/producto/delete",[$producto->id_producto]) ?>';
            }
        })
    });
})
</script>