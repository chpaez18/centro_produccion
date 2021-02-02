$('document').ready(function(){


	//validaciones javascript de las vistas lado del cliente
	$("#formulario_almacen_create").validate({
		errorClass:"form-control-danger",
		validClass: "form-control-success",
		rules:
		{
            nombre:{required:true, minlength:5},
            ubicacion:{required:true, minlength:5},
		},
		messages:
		{
			nombre:{required:"Por favor, ingrese un nombre", minlength:"Este campo acepta mínimo 5 Caracteres"},          
			ubicacion:{required:"Por favor ingrese una ubicación", minlength:"Este campo acepta mínimo 5 Caracteres"},
		}

	});    
	//fin de las validaciones javascript 

});