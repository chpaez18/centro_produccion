<?php
use Application\Router;
?>

<div class="card-box pd-20 height-100-p mb-30">
				<div class="row align-items-center">
					<div class="col-md-4">
						<img src="<?php echo $_layoutParams['ruta_assets']?>banner-img.png" alt="">
					</div>
					<div class="col-md-8">
						<h4 class="font-20 weight-500 mb-10 text-capitalize">
							Bienvenido <div class="weight-600 font-30 text-blue"><?= $model->nom_usuario ?></div>
						</h4>
						<p class="font-18 max-width-600">
							<div class="row clearfix">
								<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
									<a href="<?= ROUTER::create_action_url("administracion/cliente/list") ?>"><div class="card card-box" style="padding:10px">
										<img class="card-img-top" src="<?php echo $_layoutParams['ruta_assets']?>international-consumer.svg" alt="Card image cap">
										<center><b>Clientes</b></center>
									</div></a>
								</div>
								<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
									<a href="<?= ROUTER::create_action_url("administracion/almacen/list") ?>"><div class="card card-box" style="padding:10px">
										<img class="card-img-top" src="<?php echo $_layoutParams['ruta_assets']?>warehouse.svg" alt="Card image cap">
										<center><b>Almacenes</b></center>
									</div></a>
								</div>
								<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
									<a href="<?= ROUTER::create_action_url("administracion/producto/list") ?>"><div class="card card-box" style="padding:10px">
										<img class="card-img-top" src="<?php echo $_layoutParams['ruta_assets']?>product.svg" alt="Card image cap">
										<center><b>Productos</b></center>
									</div></a>
								</div>
								<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
									<a href="<?= ROUTER::create_action_url("administracion/inventario/list") ?>"><div class="card card-box" style="padding:10px">
										<img class="card-img-top" src="<?php echo $_layoutParams['ruta_assets']?>stock.svg" alt="Card image cap">
										<center><b>Inventarios</b></center>
									</div></a>
								</div>
							</div>
						</p>
					</div>
				</div>
</div>

<!-- <div class="row">
				<div class="col-xl-3 mb-30">
					<div class="card-box height-100-p widget-style1">
						<div class="d-flex flex-wrap align-items-center">
							<div class="progress-data">
								<div id="chart"></div>
							</div>
							<div class="widget-data">
								<div class="h4 mb-0">2020</div>
								<div class="weight-600 font-14">Contact</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 mb-30">
					<div class="card-box height-100-p widget-style1">
						<div class="d-flex flex-wrap align-items-center">
							<div class="progress-data">
								<div id="chart2"></div>
							</div>
							<div class="widget-data">
								<div class="h4 mb-0">400</div>
								<div class="weight-600 font-14">Deals</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 mb-30">
					<div class="card-box height-100-p widget-style1">
						<div class="d-flex flex-wrap align-items-center">
							<div class="progress-data">
								<div id="chart3"></div>
							</div>
							<div class="widget-data">
								<div class="h4 mb-0">350</div>
								<div class="weight-600 font-14">Campaign</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 mb-30">
					<div class="card-box height-100-p widget-style1">
						<div class="d-flex flex-wrap align-items-center">
							<div class="progress-data">
								<div id="chart4"></div>
							</div>
							<div class="widget-data">
								<div class="h4 mb-0">$6060</div>
								<div class="weight-600 font-14">Worth</div>
							</div>
						</div>
					</div>
				</div>
</div> -->
<!-- <div class="row clearfix progress-box">
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							 <input type="text" class="knob dial1" value="80" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#1b00ff" data-angleOffset="180" readonly>
							<h5 class="text-blue padding-top-10 h5">N° de Clientes</h5>
							<span class="d-block">80% Average <i class="fa fa-line-chart text-blue"></i></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							 <input type="text" class="knob dial2" value="70" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#00e091" data-angleOffset="180" readonly>
							<h5 class="text-light-green padding-top-10 h5">Almacenes</h5>
							<span class="d-block">75% Average <i class="fa text-light-green fa-line-chart"></i></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							 <input type="text" class="knob dial3" value="90" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#f56767" data-angleOffset="180" readonly>
							<h5 class="text-light-orange padding-top-10 h5">Productos</h5>
							<span class="d-block">90% Average <i class="fa text-light-orange fa-line-chart"></i></span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							 <input type="text" class="knob dial4" value="65" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#a683eb" data-angleOffset="180" readonly>
							<h5 class="text-light-purple padding-top-10 h5">Inventarios</h5>
							<span class="d-block">65% Average <i class="fa text-light-purple fa-line-chart"></i></span>
						</div>
					</div>
				</div>
</div> -->
