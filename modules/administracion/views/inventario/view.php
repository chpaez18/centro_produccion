<?php 
 use Application\Router;

 ?>
 <div class="pd-20 card-box mb-30">
    <div class="card card-box">
		<div class="card-header">
           <b>Información</b>
           <div style="float:right">
                <a href="<?= ROUTER::create_action_url("administracion/inventario/update",[$inventario->id_inventario]) ?>" class="btn-sm btn-primary"><i class="dw dw-edit2"></i> Modificar</a>
                <a id="delete_button" href="#" class="btn-sm btn-danger"><i class="dw dw-delete-3"></i></a>
           </div>
		</div>
		<div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <blockquote class="blockquote mb-0">
                        <label for=""><b>Almacen:</b></label>
                        <p><?= $inventario->almacen->nombre ?></p>
                        <br>
                       
					</blockquote>
                </div>
                <div class="col-md-3">
                    <blockquote class="blockquote mb-0">
                        <label for=""><b>Tipo:</b></label>
                        <p><?= ($inventario->tipo == 1 ? 'Producto':'Materia Prima') ?></p>
                        <br>
                       
					</blockquote>
                </div>
                <div class="col-md-3">
                    <blockquote class="blockquote mb-0">
                        <label for=""><b><?= ($inventario->tipo == 1 ? 'Producto: ':'Materia Prima: ') ?></b></label>
                        <p><?= ($inventario->tipo == 1 ? $inventario->producto->nombre:$inventario->materia->nombre) ?></p>
                        <br>
                       
					</blockquote>
                </div>
                <div class="col-md-3">
                    <blockquote class="blockquote mb-0">
                        <label for=""><b>Cantidad:</b></label>
                        <p><?= $inventario->cantidad ?></p>
                        <br>
                       
					</blockquote>
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
                window.location.href='<?= ROUTER::create_action_url("administracion/inventario/delete",[$inventario->id_inventario]) ?>';
            }
        })
    });
})
</script>