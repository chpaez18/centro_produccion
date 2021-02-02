$('document').ready(function(){


	//validaciones javascript de las vistas lado del cliente
	$("#formulario_materia_create").validate({
		errorClass:"form-control-danger",
		validClass: "form-control-success",
		rules:
		{
            nombre:{required:true, minlength:5},
            unidad:{required:true},
		},
		messages:
		{
			nombre:{required:"Por favor, ingrese un nombre", minlength:"Este campo acepta mínimo 5 Caracteres"},          
			unidad:{required:"Por favor, ingrese una unidad"},          
		}

	});    
	//fin de las validaciones javascript 

});