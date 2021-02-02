<?php
use Application\Request;
use Application\Router;
use Application\Session;
use Plasticbrain\FlashMessages\FlashMessages;

$request = new Request();
$controlador = ucwords($request->getControlador());
$microservice = ucwords($request->getMicroservice());
$ruta =  ROUTER::create_action_url("site/index");
$ruta_microservice = ROUTER::create_action_url($request->getMicroservice()."/".$request->getControlador()."/index");
		
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Sistema de Control</title>

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_styles']?>core.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_styles']?>icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_styles']?>style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_styles']?>dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_styles']?>responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_styles']?>select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_font_awesome']?>fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_font_awesome']?>all.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_styles']?>jquery.steps.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_styles']?>sweetalert2.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $_layoutParams['ruta_styles']?>jquery-jvectormap-2.0.3.css">

    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_scripts']?>jquery.min.js"></script>
    <script src="<?php echo $_layoutParams['ruta_scripts']?>core.js"></script>
    <script src="<?php echo $_layoutParams['ruta_scripts']?>script.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_scripts']?>bootstrap.min.js"></script>
    <!-- Your custom scripts (optional) -->
    <script src="<?php echo $_layoutParams['ruta_scripts']?>bootstrap-datepicker.min.js"></script>
    <script src="<?php echo $_layoutParams['ruta_scripts']?>bootstrap-datepicker.es.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_scripts']?>jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_scripts']?>jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_scripts']?>socket.io.min.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_scripts']?>jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_scripts']?>dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="<?php echo $_layoutParams['ruta_scripts']?>dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="<?php echo $_layoutParams['ruta_scripts']?>responsive.bootstrap4.min.js"></script>
	<script src="<?php echo $_layoutParams['ruta_scripts']?>sweetalert2.all.js"></script>


	<?php if(isset($this->script_propios)){ ?>
		<script src="<?php echo $_layoutParams['ruta_modules'].$request->getMicroservice().DS.'views'.DS.$request->getControlador().DS.$this->script_propios ?> "></script>
	<?php } ?>
	
</head>
<style>
			.icon-customize{
			position: absolute;
			left: 10px;
			width: 42px;
			height: 42px;
			font-size: 24px;
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			-webkit-box-align: center;
			-ms-flex-align: center;
			align-items: center;
			-webkit-box-pack: center;
			-ms-flex-pack: center;
			justify-content: center;
			color: #fff;
			background-color: transparent;
			top: 50%;
			text-align: center;
			border-radius: 4px;
			-webkit-transition: all .3s ease-in-out;
			transition: all .3s ease-in-out;
			-webkit-transform: translate(0,-50%);
			transform: translate(0,-50%);
		}
		.hidden-th{
			display:none
		}

		.test{
			
		}
</style>
<script type="text/javascript" charset="utf-8">
  
$(document).ready(function() {
    

    /*
    $('#datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: 'es'

    });*/
	//DATATABLE
    $('.<?= (!isset($this->datatable) ? 'datatable':$this->datatable) ?> thead.row_filter th').each( function () {
        var title = $(this).text();
        $(this).html( '<input class="form-control column_search" type="text" />' );
	} );

 
 

	var table = $('.<?= (!isset($this->datatable) ? 'datatable':$this->datatable) ?>').DataTable({
		scrollCollapse: true,
		autoWidth: false,
		responsive: true,
		columnDefs: [{
			targets: "datatable-nosort",
			orderable: false,
		}],
		"dom": '<"toolbar">frtip',
		"iDisplayLength": 5,
		"order": [0,"desc"],
		"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "language": {
			"url": "<?php echo $_layoutParams['ruta_scripts']?>dataTables.spanish.json",
            paginate: {
				next: '<i class="ion-chevron-right"></i>',
				previous: '<i class="ion-chevron-left"></i>'  
			}
		},

	});
	//DATATABLE
	// Apply the search
	$( '.<?= (!isset($this->datatable) ? 'datatable':$this->datatable) ?> thead.row_filter'  ).on( 'keyup', ".column_search",function () {
	
	table
		.column( $(this).parent().index() )
		.search( this.value )
		.draw();
	} );

//validaciones javascript de las vistas lado del cliente
    $("#formulario_login").validate({
      errorClass:"form-control-danger",
      validClass: "form-control-success",
      rules:
      {
        nom_usuario:{required:true},
        pass_usuario:{required:true,minlength:6},
        txtcopia: {required:true}
      },
     messages:
      {
          nom_usuario:{required:"Por favor, escriba su nombre de usuario"},          
          pass_usuario:{required:"Por favor, escriba su contraseña", minlength:"Este campo acepta mínimo 6 Caracteres"},
          txtcopia:{required:"Por favor, ingrese el código captcha"}
      }

    });    
//fin de las validaciones javascript 

});

</script>
<?php     
        if($request->getControlador() == "site" and $request->getMetodo() == "login" or $request->getControlador() == "site" and $request->getMetodo() == "registro"){
            $controlador = "";
            $ruta = "";

?>
<body class="login-page">

	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="<?= $ruta?>">
				<img style="width:25%;margin-left: -28px;" src="<?php echo $_layoutParams['ruta_assets']?>Logo Centro de Producción-02.svg" alt="" class="light-logo">
				<img style="width:50%" src="<?php echo $_layoutParams['ruta_assets']?>Logo Centro de Producción-01.svg" alt="" class="light-logo">
				</a>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="<?php echo $_layoutParams['ruta_assets']?>login-page-img.png" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
                <?php 
                    $msg = new FlashMessages();
                    if($msg->hasMessages()){ $msg->display();} 
                ?>
                <br>
                    <?php include_once $rutaView; ?>
				</div>
			</div>
		</div>
    </div>
    <?php }else{ 
		            if($request->getControlador() == "access"){
						include_once ROOT . "modules" . DS . "error" . DS . "views" . DS . "access" . DS . "index.php";
						
						exit;
					}
	?>
<body>
	<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
		</div>
		<div class="header-right">
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="<?php echo $_layoutParams['ruta_assets']?>photo1.jpg" alt="">
						</span>
						<span class="user-name"><?= Session::get("nom_usuario") ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<!-- <a class="dropdown-item" href="profile.html"><i class="dw dw-user1"></i> Profile</a>
						<a class="dropdown-item" href="profile.html"><i class="dw dw-settings2"></i> Setting</a>
						<a class="dropdown-item" href="faq.html"><i class="dw dw-help"></i> Help</a> -->
						<a class="dropdown-item" href="<?= ROUTER::create_action_url("site/cerrar")?>"><i class="dw dw-logout"></i> Salir</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="<?= ROUTER::create_action_url("site/index")?>">
				<img style="width:28%;margin-left: -28px;" src="<?php echo $_layoutParams['ruta_assets']?>Logo Centro de Producción-02.svg" alt="" class="light-logo">
				<img style="width:75%" src="<?php echo $_layoutParams['ruta_assets']?>Logo Centro de Producción-01.svg" alt="" class="light-logo">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<?php 
					for ($i=0; $i< count($menu); $i++){ 
						if(array_key_exists("items", $menu[$i])){
							$result = ArrayHelper::getValue($menu[$i], ["items"]);

							//realizamos un count para saber la cantidad de items que se definieron
							$cant_items = count($result);
							//var_dump($result);die();
							
							
					?>
						<?php if($menu[$i]["visible"]){ ?>
							<li class="dropdown">
								<a href="javascript:;" class="dropdown-toggle">
									<span class="icon-customize <?= $menu[$i]["icon"]?>"></span><span class="mtext"> <?= $menu[$i]["titulo"]?> </span>
								</a>
								<ul class="submenu">
									<?php 
										$x = 0;
										while($x < $cant_items){ 
									?>
										<?php if($result[$x]["visible"]){ 
											$var = explode("index.php",$_SERVER["REQUEST_URI"]);
											$var2 = explode("index.php",$result[$x]["enlace"]);
										?>
											<li><a href="<?= $result[$x]["enlace"]?>" class="<?= ($var2[1] == $var[1] ? 'active':'') ?>"><i class="<?= $result[$x]["icon"]?> " aria-hidden="true"></i> <?= $result[$x]["titulo"]?></a></li>
										<?php } ?>
									<?php $x++; } ?>
								</ul>
							</li>
						<?php } ?>
						
						<?php }else{ ?>
							<?php if($menu[$i]["visible"]){ ?>
								<li>
									<a href="<?= $menu[$i]["enlace"]?>" class="dropdown-toggle no-arrow">
										<span class="icon-customize <?= $menu[$i]["icon"]?>"></span><span class="mtext"><?= $menu[$i]["titulo"]?></span>
									</a>
								</li>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="mobile-menu-overlay"></div>

	<div class="main-container" style="margin-bottom:10px">
		<div class="pd-ltr-20">
            <div class="page-header">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
                                <?php if($request->getControlador() == "site" and $request->getMetodo() == "index"){ ?>
                                    <li class="breadcrumb-item"><a href="<?= $ruta?>"><i class="icon-copy fa fa-home" aria-hidden="true"></i> Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $this->titulo ?></li>
                                <?php }elseif($request->getMetodo() == "create" || $request->getMetodo() == "view" || $request->getMetodo() == "update"){  ?>
                                    <li class="breadcrumb-item"><a href="<?= $ruta?>"><i class="icon-copy fa fa-home" aria-hidden="true"></i> Inicio</a></li>
									<li class="breadcrumb-item"><a href="<?= ROUTER::create_action_url($request->getMicroservice()."/".$request->getControlador()."/list") ?>"><?= ucwords($request->getControlador()) ?></a></li>
									<li class="breadcrumb-item active" aria-current="page"><?= $this->titulo ?></li>
                                                    
                                <?php }else{ ?>
									<li class="breadcrumb-item"><a href="<?= $ruta?>"><i class="icon-copy fa fa-home" aria-hidden="true"></i> Inicio</a></li>
									<li class="breadcrumb-item active" aria-current="page"><?= $this->titulo ?></li>
								<?php } ?>
								</ol>
							</nav>
						</div>
					</div>
			</div>
			<?php 

                $msg = new FlashMessages();
				if($msg->hasMessages()){ 
					echo '<script>'.$_SESSION['flash_messages']["s"][0]["message"].'</script>';
					if(array_key_exists("s",$_SESSION['flash_messages'])){
						$_SESSION['flash_messages'] = array();
					}
				} 
				
            ?>
            <?php include_once $rutaView; ?>
		</div>
	</div>
    <?php } ?>
	<!-- js -->

	<script src="<?php echo $_layoutParams['ruta_scripts']?>jquery.dataTables.min.js"></script>
	<script src="<?php echo $_layoutParams['ruta_scripts']?>dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo $_layoutParams['ruta_scripts']?>dataTables.responsive.min.js"></script>
	<script src="<?php echo $_layoutParams['ruta_scripts']?>responsive.bootstrap4.min.js"></script>
	<script src="<?php echo $_layoutParams['ruta_scripts']?>jquery.steps.js"></script>
	<!-- <script src="<?php //echo $_layoutParams['ruta_scripts']?>apexcharts.min.js"></script>
	<script src="<?php //echo $_layoutParams['ruta_scripts']?>jquery.knob.min.js"></script>
	<script src="<?php //echo $_layoutParams['ruta_scripts']?>highcharts.js"></script>
	<script src="<?php //echo $_layoutParams['ruta_scripts']?>highcharts-more.js"></script>
	<script src="<?php //echo $_layoutParams['ruta_scripts']?>dashboard2.js"></script>
	<script src="<?php //echo $_layoutParams['ruta_scripts']?>dashboard.js"></script> -->
	
</body>
</html>