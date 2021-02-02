 <?php 
 use Application\Router;

 $x = 0;
 $cant_components = count($producto->componentes);
 
 ?>
 <div class="pd-20 card-box mb-30">
    <div class="card card-box">
		<div class="card-header">
           <b>Información</b>
           <div style="float:right">
                <a href="<?= ROUTER::create_action_url("administracion/producto/update",[$producto->id_producto]) ?>" class="btn-sm btn-primary"><i class="dw dw-edit2"></i> Modificar</a>
                <a id="delete_button" href="#" class="btn-sm btn-danger"><i class="dw dw-delete-3"></i></a>
           </div>
		</div>
		<div class="card-body">
            <div class="row">
                <div class="col-md-6">
                        <label for=""><b>Nombre:</b></label>
                        <p><?= $producto->nombre ?></p>
                        <br>
                        <label for=""> <b>Estatus</b> </label>
                        <p><?= ($producto->estatus == 0 ? '<span class="badge badge-danger">No Disponible</span>':'<span class="badge badge-success">Disponible</span>') ?></p>
                </div>
                <div class="col-md-6">
                        <label for=""><b>Componentes:</b></label>
                        <?php if($cant_components >= 1){?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Materia Prima</th>
                                            <th scope="col">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php while ($x < $cant_components) { ?>
                                        <tr>
                                            <th scope="row"><?= ($x == 0 ? '1':$x+1) ?></th>
                                            <td><?= $producto->componentes[$x]->materia->nombre." (".$producto->componentes[$x]->materia->unidad.")" ?></td>
                                            <td><?= $producto->componentes[$x]->cantidad ?></td>
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