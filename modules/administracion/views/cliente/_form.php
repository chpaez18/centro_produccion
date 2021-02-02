<?php
	use Application\Router;

	if(isset($cliente) && is_object($cliente) ){
		$isUpdate = true;
	}else{
		$isUpdate = false;
	}
?>

    <div class="pd-20 card-box mb-30">
					<div class="clearfix">
                        <?php if($isUpdate){ 
                            $ruta_action = ROUTER::create_action_url("administracion/cliente/update",[$cliente->id_cliente])
                        ?>
                            <h4 class="text-blue h4"><i class="fas fa-edit"></i> Actualizar información del cliente: <?= $cliente->nombre?></h4>
                        <?php }else{ 
                            $ruta_action = ROUTER::create_action_url("administracion/cliente/create")
                        ?>
                            <h4 class="text-blue h4"><i class="fas fa-plus-circle"></i> Agregar Cliente</h4>
                        <?php } ?>
						
					</div>
					<div class="wizard-content">
                        <?= $form->open()->action($ruta_action)->attribute('class', 'cliente-tab-wizard wizard-circle wizard')->attribute('id', 'formulario_cliente_create'); ?>
                            <h5>Información Básica</h5>
                            <?php 
                                if($isUpdate){
                                    echo $form->bind($cliente);
                                } 
                            ?>
							<section>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label >Alías:</label>
                                            <?= $form->text('alias')->addClass('form-control'); ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label >Nombre:</label>
											<?= $form->text('nombre')->addClass('form-control'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Tipo de Cliente:</label>
											<?= $form->select('tipo', ['0' => 'Externo', '1' => 'Interno'])->addClass('form-control'); ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Rif:</label>
											<?= $form->text('rif')->addClass('form-control'); ?>
										</div>
									</div>
								</div>
							</section>
							<!-- Step 2 -->
							<h5>Datos de contacto</h5>
							<section>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Número de Teléfono:</label>
											<?= $form->text('telefono')->addClass('form-control'); ?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Correo Eléctronico:</label>
											<?= $form->email('email')->addClass('form-control'); ?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Sitio Web:</label>
											<?= $form->text('website')->addClass('form-control'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Contacto:</label>
											<?= $form->text('contacto')->addClass('form-control'); ?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Teléfono de Contacto:</label>
											<?= $form->text('telefono_contacto')->addClass('form-control'); ?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Correo Eléctronico Contacto:</label>
											<?= $form->email('email_contacto')->addClass('form-control'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Dirección:</label>
											<?= $form->textarea('direccion')->rows(5)->cols(5)->addClass('form-control'); ?>
										</div>
									</div>
								</div>
							</section>
                        <?= $form->close(); ?>
					</div>
				</div>
