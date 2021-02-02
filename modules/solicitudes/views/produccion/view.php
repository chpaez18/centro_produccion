<?php 
 use Application\Router;
 use Modules\solicitudes\models\SolicitudAlmacenMateriaPrima;
 use Illuminate\Database\Capsule\Manager as Capsule;
 $cant_components = count($solicitud->producto->componentes);
 $x = 0;
 $canDeliver = $solicitud->getCanDeliver();

 ?>
 <div class="pd-20 card-box mb-30">
    <div class="card card-box">
		<div class="card-header">
           <b>Información</b>
           <?php if($solicitud->estatus == 0){ ?>
           <div style="float:right">
                <a style="display:<?=$canDeliver?>" href="<?= ROUTER::create_action_url("solicitudes/produccion/entregarProducto",[$solicitud->id_solicitud_produccion, $solicitud->id_producto]) ?>" class="btn-sm btn-success"><i class="fas fa-check"></i> Entregar</a>
           </div>
           <?php } ?>
		</div>
		<div class="card-body">
            <div class="row">
                    <div class="col-md-3">
                        <label for=""><b>Solicitud Cliente:</b></label>
                        <p><?= $solicitud->solicitudAlmacenProducto->solicitudCliente->getCustomName() ?></p>
                    </div>
                    <div class="col-md-3">
                        <label for=""><b>Producto:</b></label>
                        <p><?= $solicitud->producto->nombre ?></p>
                    </div>
                    <div class="col-md-3">
                        <label for=""><b>Cantidad Solicitada:</b></label>
                        <p><?= $solicitud->cantidad ?></p>
                    </div>
                    <div class="col-md-3">
                    <label for=""> <b>Estatus Solicitud Producción</b> </label>
                        <p><?= ($solicitud->estatus == 0 ? '<span class="badge badge-info">Solicitado</span>':'<span class="badge badge-success">Entregado</span>') ?></p>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <div class="faq-wrap">
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header">
                                            <button class="btn btn-block collapsed" data-toggle="collapse" data-target="#faq1">
                                                Componentes del Producto
                                            </button>
                                        </div>
                                        <div id="faq1" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                            <?php if($cant_components >= 1){?>
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Materia Prima</th>
                                                                <th scope="col">Cantidad</th>
                                                                <th scope="col">Estatus Solicitud Almacén</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php while ($x < $cant_components) {
                                                            $data = SolicitudAlmacenMateriaPrima::whereRaw('id_solicitud_produccion = ? and id_materia_prima = ?', [$solicitud->id_solicitud_produccion, $solicitud->producto->componentes[$x]->materia->id_materia_prima])->get()->toArray(); 
                                                        ?>
                                                            <tr>
                                                                <th scope="row"><?= ($x == 0 ? '1':$x+1) ?></th>
                                                                <td><?= $solicitud->producto->componentes[$x]->materia->nombre." (".$solicitud->producto->componentes[$x]->materia->unidad.")" ?></td>
                                                                <td><?= $solicitud->producto->componentes[$x]->cantidad ?></td>
                                                                <td><?= (empty($data ) ? '-':($data[0]["estatus"]  == 0 ? '<span class="badge badge-info">Solicitado</span>':'<span class="badge badge-success">Entregado</span>')) ?></td>
                                                                <td> 
                                                                    <?php if(empty($data) ){         
                                                                    ?>
                                                                    <?php if($solicitud->estatus != 1 ){ ?>
                                                                        <a href="<?=ROUTER::create_action_url("solicitudes/produccion/requestAlmacen",[$solicitud->id_solicitud_produccion, $solicitud->producto->componentes[$x]->materia->id_materia_prima])?>" class="btn btn-sm btn-info" type="button" > <i class="fas fa-external-link-alt"></i> Solicitar</a> 
                                                                    <?php } ?>
                                                                        
                                                                    <?php }else if($data[0]["estatus"] == 0 ){} ?>
                                                                </td>
                                                            </tr>
                                                        <?php $x++; } ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php }else{
                                                echo ' <br> Este producto no cuenta con componentes';
                                            } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
		</div>
	</div>
</div>
