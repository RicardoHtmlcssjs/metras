<?php
	require_once "../modelo/mod_usuario.php";

	$cedula=$_POST['cedula'];
	$correo=$_POST['correo'];

	$obj_usuario=new usuarios();

	$tabla="seguridad.usuarios";
	$campos="*";
	$enlace="";
	$condicion="cedula='$cedula' AND correo='$correo'";
	$func_verificar_usuario=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);

	$datos_usuario = pg_fetch_row($func_verificar_usuario);
	$usuario=$datos_usuario[1];
    $nombre=$datos_usuario[6];

	$filas=pg_num_rows($func_verificar_usuario);	

	if ($filas>0) {
    	$contrasena=md5(md5($cedula));
		$func_modificar_clave=$obj_usuario->modificar_clave($cedula, $contrasena);

		$asunto="Recuperación de Contraseña";
		$asunto=utf8_decode($asunto);
		$mensaje="Recuperación Exitosa, sus credenciales son: <br/><b>Usuario</b>: $usuario <br/> <b>Clave</b>: $cedula";
		$enviar_correo=$obj_usuario->enviar_correo($correo, $nombre, $asunto, $mensaje);
		
		echo "Operación Exitosa, su contraseña fue enviada al correo: $correo";
	}else{
		echo "Error, No existe un Usuario con esa Cedula y/o Correo";
	}
?>