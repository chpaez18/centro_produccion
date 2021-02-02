<?php
    use Application\Router;

    if(isset($producto) && is_object($producto) ){
        $isUpdate = true;
    }else{
        $isUpdate = false;
    }
    $aux = false;
    $aux2 = false;
    $select = $form->select('id_materia_prima[]', ArrayHelper::map($materias->getMaterias(),'id_materia_prima','nombre.unidad'))->addClass('form-control');
?>

<div class="pd-20 card-box mb-30">
		<div class="clearfix">
            <?php if($isUpdate){ 
                $ruta_action = ROUTER::create_action_url("administracion/producto/update",[$producto->id_producto])
            ?>
            <h4 class="text-blue h4"><i class="fas fa-edit"></i> Actualizar producto: <?= $producto->nombre?></h4>
            <?php }else{ 
                $ruta_action = ROUTER::create_action_url("administracion/producto/create")
            ?>
                <h4 class="text-blue h4"><i class="fas fa-plus-circle"></i> Agregar Producto</h4>
            <?php } ?>
						
		</div>
	<div>
        <?= $form->open()->action($ruta_action)->attribute('id', 'formulario_producto_create'); ?>
            <?php 
                if($isUpdate){
                    echo $form->bind($producto);
                } 
            ?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label >Nombre:</label>
                        <?= $form->text('nombre')->addClass('form-control'); ?>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label >Estatus:</label>
                        <?= $form->select('estatus', [1 => 'Disponible', 0 => 'No Disponible'])->addClass('form-control'); ?>
					</div>
				</div>
            </div>
            <h4 class="text-blue h4"><i class="fas fa-plus"></i> Agregar Componentes: </h4>
			<div class="row">
                <div class="col-md-12">
                    <div id="wrapper">
                        <div id="form_div">
                            <table id="employee_table" align=center style="border-collapse:separate;border-spacing: 10px 5px;">
                                <tr id="row1">
                                <?php if(isset($componentes)){ 
                                    $aux = true;
                                    $aux2 = true;
                                foreach ($componentes as $key => $value) { 
                                ?>
                                    <tr id="row-<?=$key?>">
                                        <td> 
                                            <?= $form->select('id_materia_prima[]', ArrayHelper::map($materias->getMaterias(),'id_materia_prima','nombre.unidad'))->addClass('form-control')->select($value["id_materia_prima"]) ?>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="cantidad[]" placeholder="Cantidad" value="<?= $value["cantidad"] ?>">
                                        </td>
                                        <td>
                                            <button type='button' class='btn btn-danger' onclick="delete_row('row-<?=$key?>')"><i class='fas fa-trash'></i> Eliminar</button>
                                        </td>
                                    </tr>
                                <?php } echo"<tr><td><div id='aux'>".$form->button('<i class="fas fa-plus"></i>')->addClass('btn btn-primary')->attribute('onclick', "add_row('".$select."')")."</div></td></tr>"; } ?>
                                <?php if($aux){ echo "<script>$('document').ready(function(){
                                                        $('#row_test').remove()
                                                        $('#aux').show()
                                                    });</script>"; ?>
                                       <tr id="row_test">
                                    <?php } ?>
                                    <td>
                                        <?= $select ?>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="cantidad[]" placeholder="Cantidad">
                                    </td>
                                    <td>
                                       
                                        <?= $form->button('<i class="fas fa-plus"></i>')->addClass('btn btn-primary')->attribute('onclick', "add_row('".$select."')"); ?>
                                        <?php if($aux){ ?>
                                     
                                            <button type='button' class='btn btn-danger' onclick="delete_row('row_test')"><i class='fas fa-trash'></i> Eliminar</button>
                                               
                                        <?php } ?>
                                    </td>

                                </tr>
                               
                            </table>
                            <br>
                            <center></center>
                        </div>

                    </div>
                </div>
            </div>
<br>
            
            <center><?= $form->submit('<i class="fas fa-save"></i> Guardar')->addClass('btn btn-primary')->attribute('id','btn-1'); ?></center>
        <?= $form->close(); ?>
	</div>
</div>
