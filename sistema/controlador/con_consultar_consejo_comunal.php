<?php
	require_once "../modelo/mod_mesa.php";

	$codigo_situr=$_POST['codigo_situr'];

	$obj_mesa=new mesas();


	$func_duplicidad_consejo_comunal=$obj_mesa->duplicidad_consejo_comunal($codigo_situr);

	$filas=pg_num_rows($func_duplicidad_consejo_comunal);

	if ($filas>0) {
		echo 1;
		#echo 'Error, Ya Existe una Mesa Afiliada a este Consejo Comunal.';
	}else{
		$func_consultar_consejo_comunal=$obj_mesa->consultar_consejo_comunal($codigo_situr);

		if ($resultado=pg_fetch_array($func_consultar_consejo_comunal)) {
		 	echo $resultado['nombre_consejo_comunal'];
		}else{
		 	echo 2;
		}
	}
?>