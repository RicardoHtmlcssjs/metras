<?php
	require_once "../modelo/mod_mesa.php";

  	$pk=$_POST['mesa'];

	$obj_mesa=new mesas();
	$tabla="seguridad.usuarios";
	$condicion="fk_mesa=$pk";	
	$fun_eliminar_mesa=$obj_mesa->eliminar_mesa($tabla, $condicion);

	$tabla="sistema.mesas";
	$condicion="pk_mesa=$pk";
	$fun_eliminar_mesa=$obj_mesa->eliminar_mesa($tabla, $condicion);

	$tabla="sistema.cantidad_reciclaje";
	$condicion="fk_mesa_cantidad=$pk";	
	$fun_eliminar_mesa=$obj_mesa->eliminar_mesa($tabla, $condicion);

	if ($fun_eliminar_mesa) {
		echo "Eliminación Exitosa";
	}
?>