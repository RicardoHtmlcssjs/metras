<?php
    session_start();
    require_once "../modelo/mod_usuario.php";

	$procedimiento=$_POST['procedimiento'];
  $pk=$_POST['pk'];

  $obj_usuario=new usuarios();

switch ($procedimiento) {
	case 'consultar':

    require_once "../vista/formulario_administradores.php";
	break;

	case 'registrar':

	break;

	case 'modificar':
    $pk_usuario=$pk;
    $nacionalidad=$_POST['nacionalidad'];
    $cedula=$_POST['cedula'];
    $nombre=ucwords(strtolower($_POST['nombre']));
    $apellido=ucwords(strtolower($_POST['apellido']));
    $genero=$_POST['genero'];
    $edad=$_POST['edad'];
    $nivel_academico=$_POST['nivel_academico'];    
    $nom_usr=substr($nombre, 0,1);
    $cadena=strtolower($nom_usr.$apellido);
    $usuario =str_replace(' ', '', $cadena);
    $correo=$_POST['correo'];
    $telefono=$_POST['telefono'];
    
    $fun_modificar_usuario=$obj_usuario->modificar($pk_usuario, $nacionalidad, $cedula, $nombre, $apellido, $genero, $edad, $nivel_academico, $usuario, $correo, $telefono);

    if ($fun_modificar_usuario) {
        echo 4;
    }else{
        echo 2;
    }   
	break;

	default:
      echo "Error de Ejecucion";
	break;
}
?>