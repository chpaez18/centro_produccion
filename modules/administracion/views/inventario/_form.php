<?php
    use Application\Router;

if(isset($inventario) && is_object($inventario) ){
    $isUpdate = true;
}else{
    $isUpdate = false;
}
?>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <?php if($isUpdate){ 
            $ruta_action = ROUTER::create_action_url("administracion/inventario/update",[$inventario->id_inventario])
        ?>
            <h4 class="text-blue h4"><i class="fas fa-edit"></i> Actualizar información del inventario #: <?= $inventario->id_inventario?></h4>
        <?php }else{ 
            $ruta_action = ROUTER::create_action_url("administracion/inventario/create")
        ?>
            <h4 class="text-blue h4"><i class="fas fa-plus-circle"></i> Agregar Inventario</h4>
        <?php } ?>
						
	</div>
	<div>
        <?= $form->open()->action($ruta_action)->attribute('id', 'formulario_inventario_create'); ?>
            <?php 
                if($isUpdate){
                    echo $form->bind($inventario);
                } 
            ?>
            <?php if ($isUpdate){
                    $select = $form->select('tipo', ['0' => 'Materia Prima', '1' => 'Producto'])->addClass('form-control')->select($inventario->tipo)->attribute('id','select_tipo_inventario_1');
                }else{
                    $select = $form->select('tipo', ['0' => 'Materia Prima', '1' => 'Producto'])->addClass('form-control')->attribute('id','select_tipo_inventario');
                }
            ?>
            <div class="row">
				<div class="col-md-12">
				    <div class="form-group">
						<label >Tipo de Inventario:</label>
                        <?= $select ?>
					</div>
				</div>
            </div>
            <?php if ($isUpdate && isset($inventario->id_materia_prima)){
                    $visible = 'block';
                    $select = $form->select('id_materia_prima', ArrayHelper::map($materias,'id_materia_prima',function($materias){
                        return $materias['nombre'].' ('.$materias['unidad'].")";
                     }))->addClass('form-control')->select($inventario->id_materia_prima)->attribute('id','select_materia_1');
                }else{
                    $visible = 'none';
                    $select = $form->select('id_materia_prima', ArrayHelper::map($materias,'id_materia_prima',function($materias){
                        return $materias['nombre'].' ('.$materias['unidad'].")";
                     }))->addClass('form-control')->attribute('id','select_materia');
                }
            ?>
			<div class="row" id="div_materia_prima" style="display:<?= $visible?>">
				<div class="col-md-12">
					<div class="form-group">
						<label>Materia Prima:</label>
						<?= $select ?>
					</div>
				</div>
            </div>
            <?php if ($isUpdate && isset($inventario->id_producto)){
                    $visible = 'block';
                    $select = $form->select('id_producto',ArrayHelper::map($productos,'id_producto','nombre'))->addClass('form-control')->select($inventario->id_producto)->attribute('id','select_producto_1');
                }else{
                    $visible = 'none';
                    $select = $form->select('id_producto',ArrayHelper::map($productos,'id_producto','nombre'))->addClass('form-control')->attribute('id','select_producto');
                }
            ?>
			<div class="row" id="div_producto" style="display:<?= $visible?>">
				<div class="col-md-12">
					<div class="form-group">
						<label>Producto:</label>
						<?= $select; ?>
					</div>
				</div>
			</div>
			<div class="row" >
                <div class="col-md-4">
					<div class="form-group">
						<label>Cantidad:</label>
						<?= $form->text('cantidad')->addClass('form-control'); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Almacen:</label>
						<?= $form->select('id_almacen', ArrayHelper::map($almacenes->getAlmacenes(),'id_almacen','nombre'))->addClass('form-control'); ?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Estatus:</label>
						<?= $form->select('estatus', [1 => 'Disponible', 0 => 'No Disponible'])->addClass('form-control'); ?>
					</div>
                </div>
                <?= $form->hidden('fecha_registro')->value(date("Y-m-d h:i:s")); ?>
			</div>
            <center><?= $form->submit('<i class="fas fa-save"></i> Guardar')->addClass('btn btn-primary'); ?></center>
        <?= $form->close(); ?>
	</div>
</div>
