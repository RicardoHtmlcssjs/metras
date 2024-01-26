<?php
    session_start();
    require_once "../modelo/mod_usuario.php";
    require_once "../../sistema/modelo/mod_mesa.php";
    require_once "../../sistema/modelo/mod_ubicacion.php";
    //require_once "../vista/formulario_usuario.php";
    //require_once "../../ubicacion_geografica/modelo/mod_ubicacion_geografica.php";

	$procedimiento=$_POST['procedimiento'];
  $pk=$_POST['pk'];

  $obj_usuario=new usuarios();
  $obj_mesa=new mesas();
  $obj_ubicacion=new ubicacion();

switch ($procedimiento) {
	case 'consultar':
    $tabla="seguridad.usuarios";
    $campos="*";
    $enlace="";
    $condicion="pk_usuario='$pk'";
    $consultar_usuarios=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);

    $nombre_usuario='';
    $nacionalidad='';
    $cedula='';
    $nombre='';
    $apellido='';
    $genero='';
    $nivel_academico='';
    $edad='';
    $correo='';
    $telefono='';
    $privilegio='';
    $estatus='';
    //$tipo_usuario=$_POST['tipo_usuario'];

    while ($resultado=pg_fetch_array($consultar_usuarios)){
      $nombre_usuario=$resultado['nombre_usuario'];
      $nacionalidad=$resultado['fk_nacionalidad'];
      $cedula=$resultado['cedula'];
      $nombre=$resultado['nombre'];
      $apellido=$resultado['apellido'];
      $genero=$resultado['genero'];
      $nivel_academico=$resultado['fk_nivel_academico'];      
      $edad=$resultado['edad'];
      $correo=$resultado['correo'];
      $telefono=$resultado['telefono'];
      $privilegio=$resultado['fk_privilegio'];
      $estatus=$resultado["fk_estatus"];
    }

    $tabla="seguridad.nacionalidad";
    $campos="*";
    $enlace="";
    $condicion="1=1 ORDER BY pk_nacionalidad";
    $consultar_nacionalidad=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);
    $option_nacionalidad='<option selected value="0">..</option>';
    while ($select_nacionalidad=pg_fetch_array($consultar_nacionalidad)){
          if ($nacionalidad===$select_nacionalidad["pk_nacionalidad"]){
              $option_nacionalidad=$option_nacionalidad.'<option selected value="'.$select_nacionalidad["pk_nacionalidad"].'">'.$select_nacionalidad["descripcion_nacionalidad"].'</option>';
          }else{
              $option_nacionalidad=$option_nacionalidad.'<option value="'.$select_nacionalidad["pk_nacionalidad"].'">'.$select_nacionalidad["descripcion_nacionalidad"].'</option>';
          }
    }

    $tabla="seguridad.nivel_academico";
    $campos="*";
    $enlace="";
    $condicion="1=1 ORDER BY pk_nivel_academico";
    $consultar_nivel_academico=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);
    $option_nivel_academico='<option selected value="0">SELECCIONE...</option>';
    while ($select_nivel_academico=pg_fetch_array($consultar_nivel_academico)){
          if ($nivel_academico===$select_nivel_academico["pk_nivel_academico"]){
              $option_nivel_academico=$option_nivel_academico.'<option selected value="'.$select_nivel_academico["pk_nivel_academico"].'">'.$select_nivel_academico["descripcion_nivel_academico"].'</option>';
          }else{
              $option_nivel_academico=$option_nivel_academico.'<option value="'.$select_nivel_academico["pk_nivel_academico"].'">'.$select_nivel_academico["descripcion_nivel_academico"].'</option>';
          }
    }

    $tabla="seguridad.privilegios";
    $campos="*";
    $enlace="";
    $condicion="1=1 ORDER BY pk_privilegio";
    $consultar_privilegios=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);
    $option_privilegios='<option selected value="0">SELECCIONE...</option>';
    while ($select_privilegio=pg_fetch_array($consultar_privilegios)){
          if ($privilegio===$select_privilegio["pk_privilegio"]){
              $option_privilegios=$option_privilegios.'<option selected value="'.$select_privilegio["pk_privilegio"].'">'.$select_privilegio["descripcion_privilegio"].'</option>';
          }else{
              $option_privilegios=$option_privilegios.'<option value="'.$select_privilegio["pk_privilegio"].'">'.$select_privilegio["descripcion_privilegio"].'</option>';
          }
    }

    $tabla="seguridad.estatus_usuario";
    $campos="*";
    $enlace="";
    $condicion="1=1";
    $consultar_estatus=$obj_usuario->consultar($tabla, $campos, $enlace, $condicion);
    $option_estatus='<option selected value="0">SELECCIONE...</option>';      
    while ($select_estatus=pg_fetch_array($consultar_estatus)){
          if ($estatus===$select_estatus["pk_estatus_usuario"]){
              $option_estatus=$option_estatus.'<option selected value="'.$select_estatus["pk_estatus_usuario"].'">'.$select_estatus["descripcion_estatus_usuario"].'</option>';
          }else{
              $option_estatus=$option_estatus.'<option value="'.$select_estatus["pk_estatus_usuario"].'">'.$select_estatus["descripcion_estatus_usuario"].'</option>';
          }
    }    

    $masculino=$genero==='Masculino'? "selected" : "";
    $femenino=$genero==='Femenino'? "selected" : "";

    if ($_SESSION['privilegio']) {
      $pk_usr=$_SESSION['id_usuario'];
    }else{
      $pk_usr=0;
    }
    
    $tabla="sistema.mesas";
    $campos="*";
    $enlace="INNER JOIN sistema.consejos_comunales ON sistema.mesas.fk_consejo_comunal=sistema.consejos_comunales.pk_consejo_comunal";
    $condicion="fk_usuario='$pk_usr'";
    $consultar_mesas=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);

    $pk_mesa='';
    $nombre_mesa='';
    $estado='';
    $municipio='';
    $parroquia='';
    $codigo_situr='';
    $nombre_consejo_comunal='';
    $capacidad_toneladas='';
    $poblacion_impactar='';
    $visibilidad_c_situr="display:none;";
    $visibilidad_c_toneladas="display:none;";
    
    while ($resultado=pg_fetch_array($consultar_mesas)){
      $pk_mesa=$resultado['pk_mesa'];
      $nombre_mesa=$resultado['nombre_mesa'];
      $estado=$resultado['fk_estado'];
      $municipio=$resultado['fk_municipio'];
      $parroquia=$resultado['fk_parroquia'];
      $codigo_situr=$resultado['codigo_situr'];
      $nombre_consejo_comunal=$resultado['nombre_consejo_comunal'];
      $capacidad_toneladas=$resultado['capacidad_toneladas'];
      $poblacion_impactar=$resultado['poblacion_impactar'];
    }

    $tabla="ubicacion.estado";
    $condicion="1=1 ORDER BY pk_estado";
    $consultar_estados=$obj_ubicacion->consultar($tabla, $condicion);
    $option_estado='<option selected value="0">SELECCIONE...</option>';
    while ($select_estado=pg_fetch_array($consultar_estados)){
          if ($estado===$select_estado["pk_estado"]){
              $option_estado=$option_estado.'<option selected value="'.$select_estado["pk_estado"].'">'.$select_estado["descripcion_estado"].'</option>';
          }else{
              $option_estado=$option_estado.'<option value="'.$select_estado["pk_estado"].'">'.$select_estado["descripcion_estado"].'</option>';
          }
    }

    $tabla="ubicacion.municipio";
    $condicion="1=1 ORDER BY pk_municipio";
    $consultar_municipios=$obj_ubicacion->consultar($tabla, $condicion);
    $option_municipio='<option selected value="0">SELECCIONE...</option>';
    while ($select_municipio=pg_fetch_array($consultar_municipios)){
          if ($municipio===$select_municipio["pk_municipio"]){
              $option_municipio=$option_municipio.'<option selected value="'.$select_municipio["pk_municipio"].'">'.$select_municipio["descripcion_municipio"].'</option>';
          }
    }

    $tabla="ubicacion.parroquia";
    $condicion="1=1 ORDER BY pk_parroquia";
    $consultar_parroquias=$obj_ubicacion->consultar($tabla, $condicion);
    $option_parroquia='<option selected value="0">SELECCIONE...</option>';
    while ($select_parroquia=pg_fetch_array($consultar_parroquias)){
          if ($parroquia===$select_parroquia["pk_parroquia"]){
              $option_parroquia=$option_parroquia.'<option selected value="'.$select_parroquia["pk_parroquia"].'">'.$select_parroquia["descripcion_parroquia"].'</option>';
          }
    }

    if ($codigo_situr=='NO APLICA') {
      $consejo_comunal="";
      $independiente="selected";
      $visibilidad_c_situr="display:none;";      
    }else if($codigo_situr!=''){
      $consejo_comunal="selected";
      $independiente="";
      $visibilidad_c_situr="display:block;";
    }else if ($codigo_situr=='') {
      $consejo_comunal="";      
      $independiente="";
      $visibilidad_c_situr="display:none;";
    }

    if ($capacidad_toneladas=='') {
      $si="";
      $no="";
      $seleccione="selected";
      $visibilidad_c_toneladas="display:none;";
    }else if ($capacidad_toneladas>0) {
      $si="selected";
      $no="";
      $seleccione="";
      $visibilidad_c_toneladas="display:block;";
    }else if ($capacidad_toneladas==0) {
      $si="";
      $no="selected";
      $seleccione="";
      $visibilidad_c_toneladas="display:none;";  
    }

   /* if ($capacidad_toneladas==0) {
      $si="";
      $no="selected";
      $visibilidad_c_toneladas="display:none;";  
    }else if ($capacidad_toneladas>0) {
      $si="selected";
      $no="";
      $visibilidad_c_toneladas="display:block;";
    }else if ($capacidad_toneladas=='') {
      $si="";
      $no="";
      $seleccione="selected";
      $visibilidad_c_toneladas="display:none;";
    }*/

    require_once "../vista/formulario_usuario.php";
	break;

	case 'registrar':
    $cedula=$_POST['cedula'];
    $nacionalidad=$_POST['nacionalidad'];
    $nombre=ucwords(strtolower($_POST['nombre']));
    $apellido=ucwords(strtolower($_POST['apellido']));
    $genero=$_POST['genero'];
    $edad=$_POST['edad'];
    $nivel_academico=$_POST['nivel_academico'];    
    $nom_usr=substr($nombre, 0,1);
    $cadena=strtolower($nom_usr.$apellido);
    $usuario =str_replace(' ', '', $cadena);
    $contrasena=md5(md5($cedula));
    $correo=$_POST['correo'];
    $telefono=$_POST['telefono'];
    //$privilegio=1;
    $estatus=1;
    $nombre_mesa=$_POST['nombre_mesa'];
    $estado=$_POST['estado'];
    $municipio=$_POST['municipio'];
    $parroquia=$_POST['parroquia'];
    $codigo_situr=$_POST['codigo_situr'];
    $capacidad_toneladas=$_POST['capacidad_toneladas'];
    $poblacion_impactar=$_POST['poblacion_impactar'];
    //$foto=$_POST['foto'];

    $func_consultar_consejo_comunal=$obj_mesa->consultar_consejo_comunal($codigo_situr);
    $return_fk_consejo = pg_fetch_row($func_consultar_consejo_comunal);
    $fk_consejo_comunal=$return_fk_consejo[2];


    if($_SESSION['privilegio']){
      $privilegio=2;
      $fk_mesa=$_SESSION['mesa'];
      $fun_registrar_usuario=$obj_usuario->registrar($nacionalidad, $cedula, $nombre, $apellido, $genero, $edad, $nivel_academico, $usuario, $contrasena, $correo, $telefono, $privilegio, $estatus);
      
      $return_fk = pg_fetch_row($fun_registrar_usuario);
      $fk_usuario=$return_fk[0];

        if ($fun_registrar_usuario) {
          $fun_modificar_usuario=$obj_usuario->modificar_fk($fk_usuario, $fk_mesa);
          if ($fun_modificar_usuario) {
            //echo "Registro de Usuario Exitoso USUARIO: $usuario CONTRASEÑA: $cedula";
            echo 1;
            $asunto="Resgistro de Usuario";
            $mensaje="Registro de Usuario Exitoso, sus credenciales son: <br/><b>Usuario</b>: $usuario <br/> <b>Clave</b>: $cedula.";
            $enviar_correo=$obj_usuario->enviar_correo($correo, $nombre, $asunto, $mensaje);            
          }else{
            //echo "Registro de Usuario Fallido";
            echo 2;
          }
        }else{
          //echo "Registro de Usuario Fallido";
          echo 2;
        }        
    }else{
      $privilegio=1;
      $fun_registrar_usuario=$obj_usuario->registrar($nacionalidad, $cedula, $nombre, $apellido, $genero, $edad, $nivel_academico, $usuario, $contrasena, $correo, $telefono, $privilegio, $estatus);
      
      $return_fk = pg_fetch_row($fun_registrar_usuario);
      $fk_usuario=$return_fk[0];

          if ($fun_registrar_usuario){
            $fun_registrar_mesa=$obj_mesa->registrar($nombre_mesa, $estado, $municipio, $parroquia, $fk_usuario, $fk_consejo_comunal, $capacidad_toneladas, $poblacion_impactar);
            $return_fk=pg_fetch_row($fun_registrar_mesa);
            $fk_mesa=$return_fk[0];

            if ($fun_registrar_mesa){
              $fun_modificar_usuario=$obj_usuario->modificar_fk($fk_usuario, $fk_mesa);
              //echo "Registro de Mesa y Usuario Exitoso USUARIO: $usuario CONTRASEÑA: $cedula";
              echo 3;
              $asunto="Resgistro de Usuario";
              $mensaje="Registro de Usuario Exitoso, sus credenciales son: <br/><b>Usuario</b>: $usuario <br/> <b>Clave</b>: $cedula.";
              $enviar_correo=$obj_usuario->enviar_correo($correo, $nombre, $asunto, $mensaje);
            }else{
              //echo "Registro de Mesa Fallido";
              echo 2;
            }  
          }else{
              //echo "Registro de Usuario Fallido";
            echo 2;
          }     
    }
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