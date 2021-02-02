<?php
    use Application\Router;

    if(isset($materia) && is_object($materia) ){
        $isUpdate = true;
    }else{
        $isUpdate = false;
    }
?>

<div class="pd-20 card-box mb-30">
		<div class="clearfix">
            <?php if($isUpdate){ 
                $ruta_action = ROUTER::create_action_url("administracion/materia/update",[$materia->id_materia_prima])
            ?>
            <h4 class="text-blue h4"><i class="fas fa-edit"></i> Actualizar Materia Prima: <?= $materia->nombre?></h4>
            <?php }else{ 
                $ruta_action = ROUTER::create_action_url("administracion/materia/create")
            ?>
                <h4 class="text-blue h4"><i class="fas fa-plus-circle"></i> Agregar Materia Prima</h4>
            <?php } ?>
						
		</div>
	<div>
        <?= $form->open()->action($ruta_action)->attribute('id', 'formulario_materia_create'); ?>
            <?php 
                if($isUpdate){
                    echo $form->bind($materia);
                } 
            ?>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label >Nombre:</label>
                        <?= $form->text('nombre')->addClass('form-control'); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label >Unidad:</label>
                        <?= $form->text('unidad')->addClass('form-control')->attribute('placeholder', 'Kg, Lt, Oz, etc..'); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label >Estatus:</label>
                        <?= $form->select('estatus', [1 => 'Disponible', 0 => 'No Disponible'])->addClass('form-control'); ?>
					</div>
				</div>
            </div>
            <center><?= $form->submit('<i class="fas fa-save"></i> Guardar')->addClass('btn btn-primary')->attribute('id','btn-1'); ?></center>
        <?= $form->close(); ?>
	</div>
</div>
