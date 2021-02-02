<?php
use Application\Router;


?>
<?= $builder->open()->action(ROUTER::create_action_url("dashboard/default/index"))->attribute('id', 4); ?>
<?= $builder->text('prueba'); ?>
<?= $builder->text('nombre'); ?>
<?= $builder->submit('Sign Up'); ?>
<?= $builder->close(); ?>
Hola desde dashboard