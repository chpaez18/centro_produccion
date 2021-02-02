<?php
    use Application\Router;

    if(isset($solicitud) && is_object($solicitud) ){
        $isUpdate = true;
    }else{
        $isUpdate = false;
    }
    if($solicitudCliente->getSolicitudesNoAtendidas()){
        $map = ArrayHelper::map($solicitudCliente->getSolicitudesNoAtendidas(),'id_solicitud_cliente','cliente');
        array_walk($map, function(&$value, $key){
            $value = '0'.$key.'-'.$value["nombre"];
        });
        $select = $form->select('id_solicitud_cliente', $map)->addClass('form-control');
        $display = "inline";
    }else{
        $select = 'Sin solicitudes disponibles';
        $display = "none";
    }

?>

<div class="pd-20 card-box mb-30">
		<div class="clearfix">
            <?php if($isUpdate){ 
                $ruta_action = ROUTER::create_action_url("solicitudes/almacen/update",[$solicitud->id_solicitud_almacen_producto])
            ?>
            <h4 class="text-blue h4"><i class="fas fa-edit"></i> Actualizar Solicitud: 0<?= $solicitud->id_solicitud_cliente."-".$solicitud->solicitudCliente->cliente->nombre ?></h4>
            <?php }else{ 
                $ruta_action = ROUTER::create_action_url("solicitudes/almacen/create")
            ?>
                <h4 class="text-blue h4"><i class="fas fa-plus-circle"></i> Agregar Solicitud</h4>
            <?php } ?>
						
		</div>
	<div>
        <?= $form->open()->action($ruta_action)->attribute('id', 'formulario_solicitud_almacen_create'); ?>
            <?php 
                if($isUpdate){
                    echo $form->bind($materia);
                } 
            ?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label >Solicitud del Cliente:</label>
                        <?= $select ?>
					</div>
				</div>
            </div>
            <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label >Observación:</label>
                        <?= $form->textarea('observacion')->rows(5)->cols(5)->addClass('form-control'); ?>
					</div>
				</div>
            </div>
            <center><?= $form->submit('<i class="fas fa-save"></i> Guardar')->addClass('btn btn-primary')->attribute('id','btn-1')->attribute('style','display:'.$display); ?></center>
        <?= $form->close(); ?>
	</div>
</div>
