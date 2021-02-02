<?php
use Application\Router;
use Application\TableComponent;
use Modules\solicitudes\models\SolicitudCompras;
use Illuminate\Database\Capsule\Manager as Capsule;

?>
<style>
    .hidden{
        display:none;
    }
</style>
<script type="text/javascript" charset="utf-8">
  
$(document).ready(function(){
    $('.solicitudes-compra-listado thead.row_filter th').each( function () {
        var title = $(this).text();
        $(this).html( '<input class="form-control column_search" type="text" />' );
    });
    

	var table = $('.solicitudes-compra-listado').DataTable({
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
    
    //SELECT ROW

    $('.solicitudes-compra-listado tbody').on( 'click', 'tr', function () {
        var total = 0;
        $("#btn-comprar").removeAttr("disabled");
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            $('#row-test').remove();
            $("#btn-comprar").attr("disabled","disabled");
            
        }
        else {
           
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            data = table.row( this ).data();
            var unidad = data[3].split(" - ",2)
            
            $('.solicitudes-compra-listado tr:contains("'+data[2]+'")').each(function(){
                
                data2 = table.row( this ).data()
                var cantidad = data2[3].split(" - ",2)
                total = (parseInt(total) + parseInt(cantidad[0]) )
                
            });
            var existe = $('.solicitudes-compra-listado tr:contains("'+data[2]+'")')
            if(data[7] == 1 || data[7] == 2){
                $("#btn-comprar").attr("disabled","disabled");
            }else{
                if(existe.length > 0){
                $('#row-test').remove();
                $("#listado_seleccionados tr:last").after("<tr id='row-test'> <td>"+data[0]+"</td> <td>"+data[2]+"</td> <td>"+total+' - '+unidad[1]+"</td></tr>")
                $("#auxiliar").attr("data-name", data[2]);
                $("#auxiliar").attr("data-total", total);
                $("#auxiliar").attr("data-id_solicitud_almacen_materia_prima", parseInt(data[5]));
                $("#auxiliar").attr("data-id_materia_prima", parseInt(data[6]));
                }else{
                    $("#listado_seleccionados tr:last").after("<tr id='row-test'> <td>"+data[0]+"</td> <td>"+data[2]+"</td> <td>"+total+' - '+unidad[1]+"</td></tr>")
                    $("#auxiliar").attr("data-name", data[2]);
                    $("#auxiliar").attr("data-total", total);
                    $("#auxiliar").attr("data-id_solicitud_almacen_materia_prima", parseInt(data[5]));
                    $("#auxiliar").attr("data-id_materia_prima", parseInt(data[6]));
                }
            }
        }
        
            
    } );

    $('#btn-comprar').click(function () {
        var name = $("#auxiliar").attr("data-name");
        var total = $("#auxiliar").attr("data-total");
        var id_solicitud_almacen_materia_prima = $("#auxiliar").attr("data-id_solicitud_almacen_materia_prima");
        var id_materia_prima = $("#auxiliar").attr("data-id_materia_prima");
        $.ajax({
            type: "POST",
            url: "<?= ROUTER::create_action_url("solicitudes/compra/generalBuy"); ?>",
            data: {data:{name:name, total:total, id_solicitud_almacen_materia_prima:id_solicitud_almacen_materia_prima, id_materia_prima:id_materia_prima}},
            success: function(data)          
            {   
                Swal.fire({
                    icon: 'success',
                    title: 'Materia prima comprada',
                    text: '',
                    footer: '',
                    showCloseButton: true,
                    confirmButtonColor: '#0275d8',
                    showCancelButton: false,
                    confirmButtonText: 'Ok',
                })
                .then(function (result) {
                    if (result.value) {
                        window.location.href = "<?= ROUTER::create_action_url("solicitudes/compra/list"); ?>";
                    }
                })
            }
    });
       
    });
   /* $('.solicitudes-compra-listado tbody').on( 'click', 'tr', function () {
        var selected = $(this).toggleClass('selected');
        
        if($(this).hasClass('selected')){
            data = table.row( this ).data();
            var cantidad = data[3].split(" - ",2)
            var existe = $('#listado_seleccionados tr:contains("'+data[2]+'")')
            var aux = cantidad[0]
            console.log(existe)
            if(existe.length > 0){
                //var cant = (cantidad[0] + cantidad[0])
                var aux = $('#listado_seleccionados tr:last').attr("aux");
                var total = (parseInt(aux)+parseInt(cantidad[0]))
                $('#td'+data[2]).html(total+' - '+cantidad[1])
                $('#listado_seleccionados tr:last').attr("aux", total);
                
                
            }else{
                var cant = cantidad[0]
                $("#listado_seleccionados tr:last").after("<tr id='row"+data[0]+"' aux='"+cant+"'> <td>"+data[0]+"</td> <td>"+data[2]+"</td> <td id='td"+data[2]+"' >"+cant+' - '+cantidad[1]+"</td></tr>")
                
            }
            
        }else{

            data = table.row( this ).data();
            var aux = $('#listado_seleccionados tr:last').attr("aux");
            var cantidad = data[3].split(" - ",2)
            var total = (parseInt(aux)-parseInt(cantidad[0]))
            $('#listado_seleccionados tr:last').attr("aux", total);
            $('#td'+data[2]).html(total+' - '+cantidad[1])
            
            $('#row'+data[0]).remove();
            
        }
        
    } );*/
    //SELECT ROW

	// Apply the search
	$( '.solicitudes-compra-listado thead.row_filter'  ).on( 'keyup', ".column_search",function () {
	
	table
		.column( $(this).parent().index() )
		.search( this.value )
		.draw();
	} );
})
</script>
<div class="card-box mb-30">
    <br>
    
	<div class="pb-20">
	
					<div class="pb-20">
                    
					<table class="solicitudes-compra-listado table stripe hover nowrap">
							<thead>
								<tr>
									<th>#</th>
									<th>Fecha Solicitud</th>
									<th>Materia Prima</th>
									<th>Cantidad</th>
									<th>Estatus</th>
									<th class="hidden-th"></th>
									<th class="hidden-th"></th>
									<th class="hidden-th"></th>
									<th class="datatable-nosort"></th>
								</tr>
							</thead>
							<thead class="row_filter">
								<tr>
									<th></th>
									<th>Fecha Solicitud</th>
									<th>Materia Prima</th>
									<th>Cantidad</th>
                                    <th>Estatus</th>
                                    <th class="hidden-th"></th>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($dataProvider)){
                                    foreach ($dataProvider as $key => $value) { 
									$solicitud = SolicitudCompras::find($value["id_solicitud_compra"]);
                                    $totalSolicitudes =  Capsule::select('select * from solicitud_compras where id_materia_prima = ? and id_solicitud_almacen_materia_prima = ?', [$solicitud->id_materia_prima, $solicitud->id_solicitud_almacen_materia_prima]);
                                    if($solicitud->getSolicitudesFaltantes() == count($totalSolicitudes)){
                                        $visible = true;
                                    }else{
                                        $visible = false;
                                    }
									if($key == 0){
										$key = $key+1;
									}else{
										$key = $key+1;
									}
								?>
								<tr>
                                    
									<td class="table-plus"><?= $key ?></td>
									<td><?= $solicitud->fecha_registro; ?></td>
									<td><?= $solicitud->materiaPrima->nombre; ?></td>
									<td><?= $solicitud->cantidad." - (".$solicitud->unidad.")"; ?></td>
									<td><?= ($solicitud->estatus == 0 ? "<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-light'>Solicitado</span></center>":($solicitud->estatus == 1 ? "<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-primary'>Comprado</span></center>":"<center><span style='font-size:13px;text-transform: uppercase' class='badge badge-success'>Entregado</span></center>" ) ) ?></td>
                                    <td class="hidden" id="id_solicitud_almacen_materia_prima"><?= $solicitud->id_solicitud_almacen_materia_prima; ?></td>
                                    <td class="hidden" id="id_materia_prima"><?= $solicitud->id_materia_prima; ?></td>
                                    <td class="hidden" id="estatus"><?= $solicitud->estatus; ?></td>
                                    <td>
                                            <div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                <i class="dw dw-more"></i>
                                                            </a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                    
                                                                    
                                                                    <!-- validacion ocultar boton comprar si ya se solicito una compra de la materia prima -->
                                                                    <?php if($solicitud->estatus == 0){ ?>
                                                                        <a class="dropdown-item" href="<?=ROUTER::create_action_url("solicitudes/compra/buy", [$solicitud->id_solicitud_compra])?>"><i class="fas fa-cash-register"></i> Comprar</a>
                                                                    <?php }else if( $solicitud->estatus == 1 && $visible){ ?>
                                                                        <a class="dropdown-item" href="<?=ROUTER::create_action_url("solicitudes/compra/deliver", [$solicitud->id_solicitud_compra])?>"><i class="fas fa-truck-loading"></i> Entregar</a>
                                                                    <?php }else if ($solicitud->estatus == 2){ ?>

                                                                    <?php }?>
                                                                </div>
                                                        </div>                                          
									</td>
								</tr>
								<?php }} ?>
							</tbody>
						</table>
					</div>
				
    </div>
    
    <br>
    <div class="container">
        <h2>Seleccionado</h2>
    </div>
    <table class="table stripe hover nowrap" id="listado_seleccionados">
        <thead>
			<tr>
				<th>#</th>
				<th>Materia Prima</th>
				<th>Cantidad Total</th>
            </tr>
		</thead>
    </table>
    <div>
        <input type="hidden" id="auxiliar">
        <button style="float:right;" disabled class="btn btn-primary" id="btn-comprar">Comprar</button>
    </div>
    
</div>
<br><br><br>




