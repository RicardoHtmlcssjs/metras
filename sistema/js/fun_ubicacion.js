	function select(id, id2){
		var select_id=$('#'+id).val();
		//alert(select_id);
		$.ajax({
			url: 'sistema/controlador/con_ubicacion.php',
			type: 'POST',
			//dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
			data: {select_id, id2},
		})
		.done(function(respuesta) {
			//alert(respuesta);
			$('#'+id2).html(respuesta);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
				
	}