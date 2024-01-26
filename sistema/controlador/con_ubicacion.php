<?php
	require_once "../modelo/mod_ubicacion.php";
	
	$select_id=$_POST['select_id'];
	$tabla="ubicacion.".$_POST['id2'];
	
	$obj_ubicacion=new ubicacion();

	switch ($tabla) {
		case 'ubicacion.municipio':
		$condicion="fk_estado='$select_id'";
		$func_consultar_municipio=$obj_ubicacion->consultar($tabla, $condicion);

		$option='<option value="0">SELECCIONE...</option>';
		while ($resultado=pg_fetch_array($func_consultar_municipio)){
			$option=$option.'<option value="'.$resultado["pk_municipio"].'">'.$resultado["descripcion_municipio"].'</option>';	
		}

		echo $option;

		break;

		case 'ubicacion.parroquia':
		$condicion="fk_municipio='$select_id'";
		$func_consultar_parroquia=$obj_ubicacion->consultar($tabla, $condicion);

		$option='<option value="0">SELECCIONE...</option>';
		while ($resultado=pg_fetch_array($func_consultar_parroquia)){
			$option=$option.'<option value="'.$resultado["pk_parroquia"].'">'.$resultado["descripcion_parroquia"].'</option>';	
		}

		echo $option;
		break;		
	}
?>