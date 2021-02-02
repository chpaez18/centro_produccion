<?php 
use Application\Router;
?>
            <div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Iniciar Sesión</h2>
						</div>
						<form id="formulario_login" name="form1" method="post" action="<?= ROUTER::create_action_url("site/login")?>">
							<div class="input-group custom">
								<input id="input1" name="nom_usuario" type="text" class="form-control form-control-lg" placeholder="Usuario">
                            </div>
							<div class="input-group custom">
                                <input  name="pass_usuario" type="password" class="form-control form-control-lg" placeholder="Contraseña">
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
                                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Acceder">
									</div>
								</div>
							</div>
						</form>
					</div>










		


