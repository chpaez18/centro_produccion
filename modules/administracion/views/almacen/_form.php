<?php
    use Application\Router;

    if(isset($almacen) && is_object($almacen) ){
        $isUpdate = true;
    }else{
        $isUpdate = false;
    }
?>

<div class="pd-20 card-box mb-30">
		<div class="clearfix">
            <?php if($isUpdate ){ 
                $ruta_action = ROUTER::create_action_url("administracion/almacen/update",[$almacen->id_almacen])
            ?>
            <h4 class="text-blue h4"><i class="fas fa-edit"></i> Actualizar información del almacen: <?= $almacen->nombre?></h4>
            <?php }else{ 
                $ruta_action = ROUTER::create_action_url("administracion/almacen/create")
            ?>
                <h4 class="text-blue h4"><i class="fas fa-plus-circle"></i> Agregar Almacen</h4>
            <?php } ?>
						
		</div>
	<div>
        <?= $form->open()->action($ruta_action)->attribute('id', 'formulario_almacen_create'); ?>
            <?php 
                if($isUpdate){
                    echo $form->bind($almacen);
                } 
            ?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label >Nombre:</label>
                        <?= $form->text('nombre')->addClass('form-control'); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label >Ubicación:</label>
						<?= $form->text('ubicacion')->addClass('form-control'); ?>
					</div>
				</div>
            </div>
            <center><?= $form->submit('<i class="fas fa-save"></i> Guardar')->addClass('btn btn-primary')->attribute('id','btn-1'); ?></center>
        <?= $form->close(); ?>
	</div>
</div>
