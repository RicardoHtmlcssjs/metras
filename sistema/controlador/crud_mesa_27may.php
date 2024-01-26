<?php
    session_start();
    require_once "../modelo/mod_mesa.php";
    require_once "../modelo/mod_ubicacion.php";
    //require_once "../vista/formulario_usuario.php";
    //require_once "../../ubicacion_geografica/modelo/mod_ubicacion_geografica.php";

	$procedimiento=$_POST['procedimiento'];
  $pk=$_POST['pk'];

  $obj_mesa=new mesas();
  $obj_ubicacion=new ubicacion();

switch ($procedimiento) {
	case 'consultar_materiales':
    $tabla="sistema.cantidad_reciclaje";
    $campos="*";
    $enlace="INNER JOIN seguridad.usuarios ON sistema.cantidad_reciclaje.fk_usuario=seguridad.usuarios.pk_usuario INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN sistema.materiales ON sistema.cantidad_reciclaje.fk_material=sistema.materiales.pk_material INNER JOIN sistema.peso ON sistema.cantidad_reciclaje.fk_peso=sistema.peso.pk_peso";
    $condicion="pk_cantidad_reciclaje='$pk'";
    $consultar_cantidad_reciclaje=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);

      $nombre_mesa='';
      $material='';
      $cantidad='';
      $peso='';
      $metodo_recoleccion='';
      $marca='';
      $placa='';
      $ruta_recoleccion='';                
      $cedula='';
      $nombre='';
      $apellido='';
      $responsable='';      
      $fecha='';
      $visibilidad_t_automotor="display:none;";
    
    while ($resultado=pg_fetch_array($consultar_cantidad_reciclaje)){
      $nombre_mesa=$resultado['nombre_mesa'];
      $material=$resultado['fk_material'];
      $cantidad=$resultado['cantidad'];
      $peso=$resultado['pk_peso'];
      $metodo_recoleccion=$resultado['fk_vehiculo'];
      $marca=$resultado['fk_marca'];
      $placa=$resultado['placa'];
      $ruta_recoleccion=$resultado['ruta_recoleccion'];
      $cedula=$resultado['cedula'];
      $nombre=$resultado['nombre'];
      $apellido=$resultado['apellido'];
      $responsable=$nombre." ".$apellido;      
      $fecha=$resultado['fecha'];
    }

    $tabla="sistema.materiales";
    $campos="*";
    $enlace="";
    $condicion="1=1 ORDER BY pk_material";

    $consultar_materiales=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);
    $option_material='<option selected value="0">SELECCIONE...</option>';
    while ($select_material=pg_fetch_array($consultar_materiales)){
          if ($material===$select_material["pk_material"]){
              $option_material=$option_material.'<option selected value="'.$select_material["pk_material"].'">'.$select_material["descripcion_material"].'</option>';
          }else{
              $option_material=$option_material.'<option value="'.$select_material["pk_material"].'">'.$select_material["descripcion_material"].'</option>';
          }
    }

    $tabla="sistema.peso";
    $campos="*";
    $enlace="";
    $condicion="1=1 ORDER BY pk_peso";

    $consultar_peso=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);
    $option_peso='<option selected value="0">SELECCIONE...</option>';
    while ($select_peso=pg_fetch_array($consultar_peso)){
          if ($peso===$select_peso["pk_peso"]){
              $option_peso=$option_peso.'<option selected value="'.$select_peso["pk_peso"].'">'.$select_peso["descripcion_peso"].'</option>';
          }else{
              $option_peso=$option_peso.'<option value="'.$select_peso["pk_peso"].'">'.$select_peso["descripcion_peso"].'</option>';
          }
    }

    $tabla="sistema.vehiculos";
    $campos="*";
    $enlace="";
    $condicion="1=1 ORDER BY pk_vehiculo";

    $consultar_metodo_recoleccion=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);
    $option_metodo_recoleccion='<option selected value="0">SELECCIONE...</option>';
    while ($select_metodo_recoleccion=pg_fetch_array($consultar_metodo_recoleccion)){
          if ($metodo_recoleccion===$select_metodo_recoleccion["pk_vehiculo"]){
              $option_metodo_recoleccion=$option_metodo_recoleccion.'<option selected value="'.$select_metodo_recoleccion["pk_vehiculo"].'">'.$select_metodo_recoleccion["descripcion_vehiculo"].'</option>';
          }else{
              $option_metodo_recoleccion=$option_metodo_recoleccion.'<option value="'.$select_metodo_recoleccion["pk_vehiculo"].'">'.$select_metodo_recoleccion["descripcion_vehiculo"].'</option>';
          }
    }    

    $tabla="sistema.marcas";
    $campos="*";
    $enlace="";
    $condicion="pk_marca>1 ORDER BY pk_marca";

    $consultar_marcas=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);
    $option_marca='<option selected value="0">SELECCIONE...</option>';
    while ($select_marca=pg_fetch_array($consultar_marcas)){
          if ($marca===$select_marca["pk_marca"]){
              $option_marca=$option_marca.'<option selected value="'.$select_marca["pk_marca"].'">'.$select_marca["descripcion_marca"].'</option>';
          }else{
              $option_marca=$option_marca.'<option value="'.$select_marca["pk_marca"].'">'.$select_marca["descripcion_marca"].'</option>';
          }
    }

    if ($metodo_recoleccion>51 OR $metodo_recoleccion=='') {
      $visibilidad_t_automotor="display:none;";      
    }else{
      $visibilidad_t_automotor="display:block;";
    }    

    require_once "../vista/formulario_materiales.php";
	break;

	case 'registrar_material':
    $mesa=$_SESSION['mesa'];
    $usuario=$_SESSION['id_usuario'];
    $material=$_POST['material'];
    $cantidad=$_POST['cantidad'];
    $peso=$_POST['peso'];
    $metodo_recoleccion=$_POST['metodo_recoleccion'];
    $marca=$_POST['marca'];
    $placa=$_POST['placa'];
    $ruta_recoleccion=$_POST['ruta_recoleccion'];
    $fecha=date("d/m/Y");
    //$foto=$_POST['foto'];

    $fun_registrar_material=$obj_mesa->registrar_material($mesa, $usuario, $material, $cantidad, $peso, $metodo_recoleccion, $marca, $placa, $ruta_recoleccion, $fecha);
    if ($fun_registrar_material){
      echo "Registro Exitoso";
    }else{
      echo "Registro Fallido";
    }
	break;

	case 'modificar':
    $pk_cantidad_reciclaje=$pk;
    $mesa=$_SESSION['mesa'];
    $usuario=$_SESSION['id_usuario'];
    $material=$_POST['material'];
    $cantidad=$_POST['cantidad'];
    $peso=$_POST['peso'];
    $metodo_recoleccion=$_POST['metodo_recoleccion'];
    $marca=$_POST['marca'];
    $placa=$_POST['placa'];
    $ruta_recoleccion=$_POST['ruta_recoleccion'];
    $fecha=date("d/m/Y");
    //$foto=$_POST['foto'];

    $fun_modificar_material=$obj_mesa->modificar_material($pk, $mesa, $usuario, $material, $cantidad, $peso, $metodo_recoleccion, $marca, $placa, $ruta_recoleccion, $fecha);

    if ($fun_modificar_material){
      echo "Modificación Exitosa";
    }else{
      echo "Modificación Fallida";
    }
	break;		
	
  case 'consultar_mesa':
    $tabla="sistema.mesas";
    $campos="*";
    $enlace="INNER JOIN seguridad.usuarios ON sistema.mesas.fk_usuario=seguridad.usuarios.pk_usuario INNER JOIN ubicacion.estado ON sistema.mesas.fk_estado=ubicacion.estado.pk_estado INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio INNER JOIN ubicacion.parroquia ON sistema.mesas.fk_parroquia=ubicacion.parroquia.pk_parroquia INNER JOIN sistema.consejos_comunales ON sistema.mesas.fk_consejo_comunal=sistema.consejos_comunales.pk_consejo_comunal";
    $condicion="pk_mesa='$pk'";
    $consultar_carga_mesas=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);

    $nombre_mesa='';
    $estado='';
    $municipio='';
    $parroquia='';
    $usuario='';
    $codigo_situr='';
    $nombre_consejo_comunal='';
    $capacidad_toneladas='';
    $poblacion_impactar='';
    $visibilidad_c_situr="display:none;";
    $visibilidad_c_toneladas="display:none;";  
    
    while ($resultado=pg_fetch_array($consultar_carga_mesas)){
      $nombre_mesa=$resultado['nombre_mesa'];
      $estado=$resultado['fk_estado'];
      $municipio=$resultado['fk_municipio'];
      $parroquia=$resultado['fk_parroquia'];
      $usuario=$resultado['fk_usuario'];
      $codigo_situr=$resultado['codigo_situr'];
      $nombre_consejo_comunal=$resultado['nombre_consejo_comunal'];
      $capacidad_toneladas=$resultado['capacidad_toneladas'];
      $poblacion_impactar=$resultado['poblacion_impactar'];      
    }

    $tabla="ubicacion.estado";
    $condicion="1=1 ORDER BY pk_estado";

    $consultar_estado=$obj_ubicacion->consultar($tabla, $condicion);
    $option_estado='<option selected value="0">SELECCIONE...</option>';
    while ($select_estado=pg_fetch_array($consultar_estado)){
          if ($estado===$select_estado["pk_estado"]){
              $option_estado=$option_estado.'<option selected value="'.$select_estado["pk_estado"].'">'.$select_estado["descripcion_estado"].'</option>';
          }else{
              $option_estado=$option_estado.'<option value="'.$select_estado["pk_estado"].'">'.$select_estado["descripcion_estado"].'</option>';
          }
    }

    $tabla="ubicacion.municipio";
    $condicion="1=1 ORDER BY pk_municipio";

    $consultar_municipio=$obj_ubicacion->consultar($tabla, $condicion);
    $option_municipio='<option selected value="0">SELECCIONE...</option>';
    while ($select_municipio=pg_fetch_array($consultar_municipio)){
          if ($municipio===$select_municipio["pk_municipio"]){
              $option_municipio=$option_municipio.'<option selected value="'.$select_municipio["pk_municipio"].'">'.$select_municipio["descripcion_municipio"].'</option>';
          }
    }

    $tabla="ubicacion.parroquia";
    $condicion="1=1 ORDER BY pk_parroquia";

    $consultar_parroquia=$obj_ubicacion->consultar($tabla, $condicion);
    $option_parroquia='<option selected value="0">SELECCIONE...</option>';
    while ($select_parroquia=pg_fetch_array($consultar_parroquia)){
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

    require_once "../vista/formulario_carga_mesa.php";
  break;

  case 'modificar_mesa':
    $pk_pesa=$pk;
    $nombre_mesa=$_POST['nombre_mesa'];
    $estado=$_POST['estado'];
    $municipio=$_POST['municipio'];
    $parroquia=$_POST['parroquia'];
    $codigo_situr=$_POST['codigo_situr'];
    $capacidad_toneladas=$_POST['capacidad_toneladas'];
    $poblacion_impactar=$_POST['poblacion_impactar'];           

    $func_consultar_consejo_comunal=$obj_mesa->consultar_consejo_comunal($codigo_situr);
    $return_fk_consejo = pg_fetch_row($func_consultar_consejo_comunal);
    $fk_consejo_comunal=$return_fk_consejo[2];
    
    $fun_modificar_mesa=$obj_mesa->modificar_mesa($pk_pesa, $nombre_mesa, $estado, $municipio, $parroquia, $fk_consejo_comunal, $capacidad_toneladas, $poblacion_impactar);

    if ($fun_modificar_mesa) {
        echo "Modificación Exitosa";
    }else{
        echo "Modificación Fallida";
    } 
  break;
	default:
  echo "Error de Ejecucion";
	break;
}
?>