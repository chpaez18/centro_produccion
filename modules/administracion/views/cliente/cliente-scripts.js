$('document').ready(function(){


	//FORMULARIO CREATE WIZARD
	$(".cliente-tab-wizard").steps({
		headerTag: "h5",
		bodyTag: "section",
		transitionEffect: "fade",
		titleTemplate: '<span class="step">#index#</span> #title#',
		labels: {
			finish: "<i class='fas fa-save'></i> Guardar",
			next: "<i class='fas fa-arrow-right'></i> Siguiente",
			previous: "<i class='fas fa-arrow-left'></i> Anterior",
		},
		onStepChanging: function (event, currentIndex, newIndex)
		{
			if (currentIndex > newIndex)
			{
				return true;
			}
			if (newIndex === 3 && Number($("#age-2").val()) < 18)
			{
				return false;
			}
			if (currentIndex < newIndex)
			{
				$(".cliente-tab-wizard").find(".body:eq(" + newIndex + ") label.error").remove();
				$(".cliente-tab-wizard").find(".body:eq(" + newIndex + ") .error").removeClass("error");
			}
			$(".cliente-tab-wizard").validate().settings.ignore = ":disabled,:hidden";
			return $(".cliente-tab-wizard").valid();
		},
		onStepChanged: function (event, currentIndex, priorIndex)
		{
			// Used to skip the "Warning" step if the user is old enough.
			if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
			{
				$(".cliente-tab-wizard").steps("Siguiente");
			}
			// Used to skip the "Warning" step if the user is old enough and wants to the previous step.
			if (currentIndex === 2 && priorIndex === 3)
			{
				$(".cliente-tab-wizard").steps("Anterior");
			}
		},
		onFinishing: function (event, currentIndex)
		{
			$(".cliente-tab-wizard").validate().settings.ignore = ":disabled";
			return $(".cliente-tab-wizard").valid();
		},
		onFinished: function (event, currentIndex)
		{
			$("#formulario_cliente_create").submit();
		}
	});
	//FORMULARIO CREATE WIZARD


	//validaciones javascript de las vistas lado del cliente
	$("#formulario_cliente_create").validate({
		errorClass:"form-control-danger",
		validClass: "form-control-success",
		rules:
		{
		alias:{required:true},
		nombre:{required:true},
		rif: {required:true},
		telefono: {required:true},
		email: {required:true,email:true}
		},
		messages:
		{
			alias:{required:"Por favor, ingrese un alías"},          
			nombre:{required:"Por favor escriba un nombre"},
			rif:{required:"Por favor, ingrese su número de rif"},
			telefono:{required:"Por favor, ingrese su número telefonico"},
			email:{required:"Por favor, ingrese un correo eléctronico",email:"Ingrese un correo válido"},
		}

	});    
	//fin de las validaciones javascript 

});