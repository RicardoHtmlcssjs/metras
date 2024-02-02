class Acciones_usuario{
    certificado_inscrip(pk, procedimiento){
        $.ajax({
			url: "usuario/controlador/crud_usuario.php",
			type: "POST",
            data: {
                pk: pk, procedimiento: procedimiento
            },
			success: function(result){
				alert(result);

			},
			error: function(error){
				alert();
				// console.log(error);
			}

		});
    }
}
let acciones_usuarios = new Acciones_usuario();