$('document').ready(function(){


	//validaciones javascript de las vistas lado del cliente
	$("#formulario_producto_create").validate({
		errorClass:"form-control-danger",
		validClass: "form-control-success",
		rules:
		{
            nombre:{required:true},
            "cantidad[]" :{required:true},
            estatus:{required:true},
		},
		messages:
		{
			nombre:{required:"Por favor, ingrese un nombre"},          
			"cantidad[]":{required:"Por favor, ingrese una cantidad"},        
			estatus:{required:"Por favor, ingrese un estatus"},          
		}

	});    
	//fin de las validaciones javascript 

});

function add_row(select)
{

	$rowno=$("#employee_table tr").length;
	$rowno=$rowno+1;
	$select = select;
	$("#employee_table tr:last").after("<tr id='row"+$rowno+"'> <td>"+$select+"</td><td> <input type='text' class='form-control' name='cantidad[]' placeholder='Cantidad'> </td><td><button type='button' class='btn btn-danger' onclick=delete_row('row"+$rowno+"')><i class='fas fa-trash'></i> Eliminar</button></td></tr>");
	}
	function delete_row(rowno)
	{
	$('#'+rowno).remove();
}