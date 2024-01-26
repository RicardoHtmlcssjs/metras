<?php
	require_once "../modelo/mod_usuario.php";

	$clave_actual=md5(md5($_POST['clave_actual']));
	$id_usuario=$_POST['usuario'];
	$nueva_clave=$_POST['nueva_clave'];

	$obj_usuario=new usuarios();

	$tabla="seguridad.usuarios";
	$campos="*";
	$enlace="";
	$condicion="pk_usuario='$id_usuario' AND contrasena='$clave_actual'";
	$func_verificar_usuario=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);

	$datos_usuario = pg_fetch_row($func_verificar_usuario);
	$usuario=$datos_usuario[1];
	$cedula=$datos_usuario[5];
    $nombre=$datos_usuario[6];
    $correo=$datos_usuario[9];
    
	$filas=pg_num_rows($func_verificar_usuario);	

	if ($filas>0) {
    	$contrasena=md5(md5($nueva_clave));
		$func_modificar_clave=$obj_usuario->modificar_clave($cedula, $contrasena);

		$asunto="Cambio de Clave Exitoso";
		$asunto=utf8_decode($asunto);
		$mensaje="Cambio  de Clave Exitoso, sus credenciales son: <br/><b>Usuario</b>: $usuario <br/> <b>Clave</b>: $nueva_clave";
		$enviar_correo=$obj_usuario->enviar_correo($correo, $nombre, $asunto, $mensaje);
		
		echo "Operación Exitosa, su clave fue enviada al correo: $correo";
	}else{
		echo "Error, Clave Inválida";
	}
?>