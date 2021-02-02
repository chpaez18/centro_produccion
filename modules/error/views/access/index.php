<?php
use Application\Router;
use Application\Session;
?>
<body>
	<div class="error-page d-flex align-items-center flex-wrap justify-content-center pd-20">
		<div class="pd-10">
			<div class="error-page-wrap text-center">
				<h1><?php if($this->content["code"]) echo $this->content["code"]; ?></h1>
				<h3>Error: <?php if($this->content["code"]) echo $this->content["code"]; ?> <?php if($this->content["tittle"]) echo $this->content["tittle"]; ?> !</h3>
				<p><?php if($this->content["message"]) echo $this->content["message"]; ?></p>
				<div class="pt-20 mx-auto max-width-200">
                    <a href="<?php echo ROUTER::create_action_url("site/index")?>" class="btn btn-primary btn-block btn-lg">Regresar Al Inicio</a>
                    <?php //si el usuario no tiene sesion iniciada
                        if(!Session::get("autenticado")){ ?>

                        <a href="<?php echo ROUTER::create_action_url("site/login")?>" class="btn btn-primary btn-block btn-lg" >Iniciar Sesión</a> 

                    <?php } ?>
				</div>
			</div>
		</div>
	</div>
	
</body>