<?php
    use Application\Router;

    if(isset($solicitudes) && is_object($solicitudes) ){
        $isUpdate = true;
    }else{
        $isUpdate = false;
    }
    $aux = false;
    $aux2 = false;
    $select = $form->select('id_producto[]', ArrayHelper::map($productos->getProductos(),'id_producto','nombre'))->addClass('form-control');
?>

<div class="pd-20 card-box mb-30">
<div class="clearfix">
            <?php if($isUpdate ){ 
                $ruta_action = ROUTER::create_action_url("solicitudes/default/update",[$solicitudes->id_solicitud_cliente])
            ?>
            <h4 class="text-blue h4"><i class="fas fa-edit"></i> Actualizar información de la solicitud: # <?= $solicitudes->id_solicitud_cliente?></h4>
            <?php }else{ 
                $ruta_action = ROUTER::create_action_url("solicitudes/default/create")
            ?>
                <h4 class="text-blue h4"><i class="fas fa-plus-circle"></i> Agregar Solicitud</h4>
            <?php } ?>
						
		</div>
	<div>
        <?= $form->open()->action($ruta_action)->attribute('id', 'formulario_solicitud_create'); ?>
            <?php 
                if($isUpdate){
                    echo $form->bind($solicitudes);
                } 
            ?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label >Cliente:</label>
                        <?= $form->select('id_cliente', ArrayHelper::map($clientes->getClientes(),'id_cliente','nombre'))->addClass('form-control'); ?>
					</div>
				</div>
            </div>
            <h4 class="text-blue h4"><i class="fas fa-plus"></i> Agregar Productos: </h4>
			<div class="row">
                <div class="col-md-12">
                    <div id="wrapper">
                        <div id="form_div">
                            <table id="employee_table_1" align=center style="border-collapse:separate;border-spacing: 10px 5px;">
                                <tr id="row1">
                                <?php if(isset($items)){ 
                                    $aux = true;
                                    $aux2 = true;
                                foreach ($items as $key => $value) { 
                                ?>
                                    <tr id="row-<?=$key?>">
                                        <td> 
                                            <?= $form->select('id_producto[]', ArrayHelper::map($productos->getProductos(),'id_producto','nombre'))->addClass('form-control')->select($value["id_producto"]) ?>
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
            <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label >Observación:</label>
                        <?= $form->textarea('observacion')->rows(5)->cols(5)->addClass('form-control'); ?>
					</div>
				</div>
            </div>
<br>
            <?= $form->hidden('fecha_registro')->value(date("Y-m-d h:i:s")); ?>
            <center><?= $form->submit('<i class="fas fa-save"></i> Guardar')->addClass('btn btn-primary')->attribute('id','btn-1'); ?></center>
        <?= $form->close(); ?>
	</div>
</div>
