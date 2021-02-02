<?php 
 use Application\Router;

 ?>
 <div class="pd-20 card-box mb-30">
    <div class="card card-box">
		<div class="card-header">
           <b>Información</b>
           <div style="float:right">
                <a href="<?= ROUTER::create_action_url("administracion/cliente/update",[$cliente->id_cliente]) ?>" class="btn-sm btn-primary"><i class="dw dw-edit2"></i> Modificar</a>
                <a id="delete_button" href="#" class="btn-sm btn-danger"><i class="dw dw-delete-3"></i></a>
           </div>
		</div>
		<div class="card-body">
            <div class="row">
                <div class="col-md-4">
                        <label for=""><b>Alias:</b></label>
                        <p style="color:green"><b><?= ($cliente->alias ? $cliente->alias:'N/D'); ?></b></p>
                        <br>
                </div>
                <div class="col-md-4">
                        <label for=""><b>Nombre:</b></label>
                        <p style="color:green"><b><?= ($cliente->nombre ? $cliente->nombre:'N/D'); ?></b></p>
                        <br>
                       
                </div>
                <div class="col-md-3">
                        <label for=""><b>Rif:</b></label>
                        <p><?= ($cliente->rif ? $cliente->rif:'N/D'); ?></p>
                        <br>
                       
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                        <label for=""><b>Telefono:</b></label>
                        <p><?= ($cliente->telefono ? $cliente->telefono:'N/D'); ?></p>
                        <br>
                       
                </div>
                <div class="col-md-4">
                        <label for=""><b>Correo Electronico:</b></label>
                        <p><?= ($cliente->email ? $cliente->email:'N/D'); ?></p>
                        <br>
                       
                </div>
                <div class="col-md-4">
                        <label for=""><b>Website:</b></label>
                        <p><?= ($cliente->website ? $cliente->website:'N/D'); ?></p>
                        <br>
                       
                </div>

            </div>
            <legend><i class="fas fa-address-book"></i> Información de Contacto</legend><hr>
            <div class="row">
                <div class="col-md-4">
                        <label for=""><b>Contacto:</b></label>
                        <p><?= ($cliente->nombre_contacto ? $cliente->nombre_contacto:'N/D'); ?></p>
                        <br>
                       
                </div>
                <div class="col-md-4">
                        <label for=""><b>Telefono de Contacto:</b></label>
                        <p><?= ($cliente->telefono_contacto ? $cliente->telefono_contacto:'N/D'); ?></p>
                        <br>
                       
                </div>
                <div class="col-md-4">
                        <label for=""><b>Correo de Contacto:</b></label>
                        <p><?= ($cliente->email_contacto ? $cliente->email_contacto:'N/D'); ?></p>
                        <br>
                       
                </div>
            </div>
            <legend><i class="fas fa-map-marker-alt"></i> Dirección</legend><hr>
            <div class="row">
                <div class="col-md-12">
                        <p><?= ($cliente->direccion ? $cliente->direccion:'N/D'); ?></p>
                        <br>
                       
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
                window.location.href='<?= ROUTER::create_action_url("administracion/cliente/delete",[$cliente->id_cliente]) ?>';
            }
        })
    });
})
</script>