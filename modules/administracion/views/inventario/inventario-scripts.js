$('document').ready(function(){

	let searchParams = new URLSearchParams(window.location.search)
	let param = searchParams.get('url');
	let action = param.split("/")[2];

    //FORMULARIO CREATE
    
    $('#select_producto').val('<option value="0">Seleccione...</option>');
    $('#select_materia').val('<option value="0">Seleccione...</option>');
    $('#select_tipo_inventario').val('<option value="0">Seleccione...</option>');

    $("#select_tipo_inventario").change(function(){
        var selected = $(this).children("option:selected").val();
        if(selected == 0){
            $('#div_materia_prima').attr('style','display:block');
            $('#div_producto').attr('style','display:none');
            $('#select_producto').val(0);
        }else if(selected == 1){
            $('#div_producto').attr('style','display:block');
            $('#div_materia_prima').attr('style','display:none');
            $('#select_materia').val(0);
        }
    });
    $("#select_tipo_inventario_1").change(function(){
        var selected = $(this).children("option:selected").val();
        if(selected == 0){
            $('#div_materia_prima').attr('style','display:block');
            $('#div_producto').attr('style','display:none');
            $('#select_producto_1').val("");
        }else if(selected == 1){
            $('#div_producto').attr('style','display:block');
            $('#div_materia_prima').attr('style','display:none');
            $('#select_materia_1').val("");
        }
    });
	//FORMULARIO CREATE


	//validaciones javascript de las vistas lado del cliente
	$("#formulario_inventario_create").validate({
		errorClass:"form-control-danger",
		validClass: "form-control-success",
		rules:
		{
            tipo:{required:true},
            id_producto:{
                required: function(element) {
                    if( $("#select_tipo_inventario").val() =='1'){
                      return true;
                    } else {
                      return false;
                    }
                  }
            },
            id_materia_prima:{
                required: function(element) {
                    if( $("#select_tipo_inventario").val() =='0'){
                      return true;
                    } else {
                      return false;
                    }
                  }
            },
            id_almacen:{required:true},
            cantidad:{required:true},
            estatus:{required:true},
		},
		messages:
		{
			tipo:{required:"Por favor, seleccione una opción"},          
			id_producto:{required:"Por favor, seleccione un producto"},
			id_materia_prima:{required:"Por favor, seleccione una materia prima"},
			id_almacen:{required:"Por favor, seleccione un almacen"},
			cantidad:{required:"Por favor, ingrese una cantidad"},
			estatus:{required:"Por favor, seleccione un estatus"},
		}

	});    
	//fin de las validaciones javascript 

});