<?php require_once "../modelo/mod_usuario.php";
	$nombre_usuario=$_POST['nombre_usuario'];
	$clave_usuario=md5(md5($_POST['clave_usuario']));
	$accion=$_POST['accion'];

	$tabla="seguridad.usuarios";
	$campos="*";
	$enlace="INNER JOIN sistema.mesas ON seguridad.usuarios.fk_mesa=sistema.mesas.pk_mesa INNER JOIN seguridad.estatus_usuario ON seguridad.usuarios.fk_estatus=seguridad.estatus_usuario.pk_estatus_usuario INNER JOIN seguridad.privilegios ON seguridad.usuarios.fk_privilegio=seguridad.privilegios.pk_privilegio";
	$condicion="nombre_usuario='$nombre_usuario' AND contrasena='$clave_usuario'";

	switch ($accion) {
		case 'abrir':
			$obj_usuario=new usuarios();
			$func_consultar=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);
			
			if ($resultado=pg_fetch_array($func_consultar)){
				session_start();
				$_SESSION['id_usuario']=$resultado['pk_usuario'];
				$_SESSION['nombre']=$resultado['nombre_usuario'];
				$_SESSION['estatus']=$resultado['fk_estatus'];
				$_SESSION['privilegio']=$resultado['fk_privilegio'];
				$_SESSION['mesa']=$resultado['fk_mesa'];
				echo "datos-validos";
			}else{
				echo "datos-invalidos";
			}
		break;

		case 'cerrar':
			session_start();
			session_destroy();

			echo "sesion-cerrada";
		break;
		
		default:
			# code...
		break;
	}
?>