<?php
	require_once "../modelo/mod_usuario.php";
	require_once "../../sistema/modelo/mod_saime.php";

	$valor=$_POST['valor'];
	$campo=$_POST['campo'];
	$nacionalidad=$_POST['nacionalidad'];
	//$modelo=$_POST['modelo'];
	//$clase=$_POST['clase'];

	$obj_usuario=new usuarios();
	$obj_saime=new saime();	

	switch ($campo) {
		case 'cedula':
				$valor1=$valor;
				$valor2="";
				$valor3="";
				
				$func_verificar_duplicidad=$obj_usuario->verificar_duplicidad($valor1, $valor2, $valor3);

				$filas=pg_num_rows($func_verificar_duplicidad);

				if ($filas>0) {
					//echo '<strong>Error!</strong> Ya Existe un Usuario con esta Cedula.';
					echo 1;					
				}else{
					$tabla = ($nacionalidad==1) ? "dsaime": "dsaimextranjero";
					$campos="cedula, primer_nombre, primer_apellido, sexo, fecha_nacimiento";
					$enlace="";
					$condicion="cedula=$valor1";
					$func_consultar_saime=$obj_saime->consultar($tabla, $campos, $enlace, $condicion);

					$primer_nombre='';
					$primer_apellido='';
					$sexo='';
					$fecha_nacimiento='';

					while ($resultado=pg_fetch_array($func_consultar_saime)) {
						$cedula=$resultado['cedula'];
						$primer_nombre=$resultado['primer_nombre'];
						$primer_apellido=$resultado['primer_apellido'];
						$sexo=$resultado['sexo'];
						$fecha_nacimiento=$resultado['fecha_nacimiento'];
					}

				    $masculino=$sexo==='M'? "selected" : "";
				    $femenino=$sexo==='F'? "selected" : "";

					$captura_fecha_nacimiento = new DateTime("$fecha_nacimiento");
					$hoy = new DateTime();
					$edad = $hoy->diff($captura_fecha_nacimiento);
		    					
?>
	                    <div class="col-md-4">
	                      <div class="form-group">
	                        <label for="nombre">Nombre:</label>
	                        <input type="text" id="nombre" class="form-control tipocaracter" value="<?php echo $primer_nombre; ?>">
	                      </div>
	                    </div>
	                    <div class="col-md-4">
	                      <div class="form-group">
	                        <label for="apellido">Apellido:</label>
	                        <input type="text" id="apellido" class="form-control tipocaracter" value="<?php echo $primer_apellido; ?>">
	                      </div>
	                    </div>
	                    <div class="col-md-3">
	                      <div class="form-group">
	                        <label>Genero</label>
	                        <select id="genero" class="form-control">
	                            <option value="0">SELECCIONE...</option>
	                            <option <?php echo $masculino; ?> value="Masculino">Masculino</option>
	                            <option <?php echo $femenino; ?> value="Femenino">Femenino</option>
	                        </select>
	                      </div>
	                    </div>
	                    <div class="col-md-1" style="padding-left: 0;">
	                      <div class="form-group">
	                        <label for="edad">Edad:</label>
	                        <input type="text" id="edad" class="form-control tiponumerico" value="<?php echo $edad->y; ?>" maxlength="2">
	                      </div>
	                    </div>

<?php

				}
		break;

		case 'correo':
				$valor1=0;
				$valor2=$valor;
				$valor3="";

				$func_verificar_duplicidad=$obj_usuario->verificar_duplicidad($valor1, $valor2, $valor3);

				$filas=pg_num_rows($func_verificar_duplicidad);

					if ($filas>0) {
						echo 2;					
					}else{
						echo "valida";
					}
		break;

		case 'telefono':
				$valor1=0;
				$valor2="";
				$valor3=$valor;

				$func_verificar_duplicidad=$obj_usuario->verificar_duplicidad($valor1, $valor2, $valor3);

				$filas=pg_num_rows($func_verificar_duplicidad);

					if ($filas>0) {
						echo 3;					
					}else{
						echo "valida";
					}			
		break;

		default:
			# code...
		break;
	}
?>