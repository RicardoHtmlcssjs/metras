class Acciones_usuario{
    certificado_inscrip(num){
        $.ajax({
			url: "usuario/js/ajax/certificado_inscrip.php",
			type: "POST",
            data: {
                num: num
            },
			success: function(result){
				alert(result);

			},
			error: function(error){
				console.log(error);
			}

		});
    }
}
let acciones_usuarios = new Acciones_usuario();