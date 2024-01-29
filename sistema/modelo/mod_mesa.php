<?php
	require_once "mod_conexion.php";

	class mesas extends conexion{
		private $pk_mesa;
	    private $nombre_mesa;
	    private $fk_estado;
	    private $fk_municipio;
		private $fk_parroquia;
		private $fk_usuario;
		private $codigo_situr;
		private $capacidad_toneladas;

	    private $mesa;
	    private $usuario;
	    private $material;
		private $cantidad;
		private $peso;
		private $fecha;
		private $pg_connect;

		function __construct(){
			parent::__construct();
			$this->pg_connect=parent::conectar();
		}
		
		function consultar($tabla, $campos, $enlace, $condicion){
			$sql="SELECT $campos FROM $tabla $enlace WHERE $condicion";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function consultar_consejo_comunal($codigo_situr){
			$sql="SELECT * FROM sistema.consejos_comunales WHERE codigo_situr='$codigo_situr'";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function duplicidad_consejo_comunal($codigo_situr){
			$sql="SELECT fk_consejo_comunal FROM sistema.mesas INNER JOIN sistema.consejos_comunales ON sistema.mesas.fk_consejo_comunal=sistema.consejos_comunales.pk_consejo_comunal  WHERE codigo_situr='$codigo_situr'";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function consultar_cant_mesas($condicion){
			$sql="SELECT pk_estado, descripcion_estado, pk_municipio, descripcion_municipio, (SELECT COUNT(pk_mesa) FROM sistema.mesas WHERE sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio) AS cant_mesas  FROM ubicacion.municipio INNER JOIN ubicacion.estado ON ubicacion.municipio.fk_estado=ubicacion.estado.pk_estado WHERE (SELECT COUNT(pk_mesa) FROM sistema.mesas WHERE sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio $condicion)>0 ORDER BY pk_municipio";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function consultar_cant_mesas_e($condicion){
			$sql="SELECT pk_estado, descripcion_estado, (SELECT COUNT(pk_mesa) FROM sistema.mesas WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado) AS cant_mesas  FROM ubicacion.estado WHERE (SELECT COUNT(pk_mesa) FROM sistema.mesas WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado $condicion)>0 ORDER BY pk_estado";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function consultar_total_mesas(){
			$sql="SELECT (SELECT COUNT(pk_mesa) FROM sistema.mesas) AS total_mesas";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;			
		}

		function consultar_cant_integrantes($condicion){
			$sql="SELECT pk_estado, descripcion_estado, pk_municipio, descripcion_municipio, (SELECT COUNT(pk_usuario) FROM seguridad.usuarios INNER JOIN sistema.mesas ON seguridad.usuarios.fk_mesa=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio AND fk_privilegio!=3 AND fk_mesa>0) AS cant_integrantes FROM ubicacion.municipio INNER JOIN ubicacion.estado ON ubicacion.municipio.fk_estado=ubicacion.estado.pk_estado WHERE (SELECT COUNT(pk_usuario) FROM seguridad.usuarios INNER JOIN sistema.mesas ON seguridad.usuarios.fk_mesa=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio  AND fk_privilegio!=3 AND fk_mesa>0 $condicion)>0 ORDER BY pk_municipio";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function consultar_cant_integrantes_e($condicion){
			$sql="SELECT pk_estado, descripcion_estado, (SELECT COUNT(pk_usuario) FROM seguridad.usuarios INNER JOIN sistema.mesas ON seguridad.usuarios.fk_mesa=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_privilegio!=3 AND fk_mesa>0) AS cant_integrantes FROM ubicacion.estado WHERE (SELECT COUNT(pk_usuario) FROM seguridad.usuarios INNER JOIN sistema.mesas ON seguridad.usuarios.fk_mesa=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado  AND fk_privilegio!=3 AND fk_mesa>0 $condicion)>0 ORDER BY pk_estado";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function consultar_total_integrantes(){
			$sql="SELECT (SELECT COUNT(pk_usuario) FROM seguridad.usuarios WHERE fk_privilegio!=3 AND fk_mesa>0) AS total_integrantes";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;			
		}

		function consultar_cant_reciclaje(){
			$sql="SELECT pk_estado, descripcion_estado, pk_municipio, descripcion_municipio, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio AND fk_peso=1) AS cant_material_reciclado_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio AND fk_peso=2) AS cant_material_reciclado_t FROM ubicacion.municipio INNER JOIN ubicacion.estado ON ubicacion.municipio.fk_estado=ubicacion.estado.pk_estado WHERE  (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio AND fk_peso=1)>0 OR (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio AND fk_peso=2)>0 ORDER BY pk_municipio";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function consultar_cant_reciclaje_e(){
			$sql="SELECT pk_estado, descripcion_estado, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_peso=1) AS cant_material_reciclado_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_peso=2) AS cant_material_reciclado_t FROM ubicacion.estado WHERE  (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_peso=1)>0 OR (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_peso=2)>0 ORDER BY pk_estado";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function total_reciclaje(){
			$sql="SELECT (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje WHERE fk_peso=1) AS total_material_reciclado_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje WHERE fk_peso=2) AS total_material_reciclado_t";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;			
		}


		function cant_reciclaje_estado(){
			$sql="SELECT pk_estado, descripcion_estado, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=1 AND fk_peso=1) AS cant_material_plastico_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=1 AND fk_peso=2) AS cant_material_plastico_t, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=2 AND fk_peso=1) AS cant_material_vidrio_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=2 AND fk_peso=2) AS cant_material_vidrio_t, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=3 AND fk_peso=1) AS cant_material_carton_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=3 AND fk_peso=2) AS cant_material_carton_t, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=4 AND fk_peso=1) AS cant_material_organico_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=4 AND fk_peso=2) AS cant_material_organico_t, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=5 AND fk_peso=1) AS cant_material_papel_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=5 AND fk_peso=2) AS cant_material_papel_t, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=6 AND fk_peso=1) AS cant_material_baterias_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=6 AND fk_peso=2) AS cant_material_baterias_t, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=7 AND fk_peso=1) AS cant_material_ferroso_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=7 AND fk_peso=2) AS cant_material_ferroso_t, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=8 AND fk_peso=1) AS cant_material_textiles_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=8 AND fk_peso=2) AS cant_material_textiles_t, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=9 AND fk_peso=1) AS cant_material_neumaticos_k, (SELECT SUM(cantidad) FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE sistema.mesas.fk_estado=ubicacion.estado.pk_estado AND fk_material=9 AND fk_peso=2) AS cant_material_neumaticos_t FROM ubicacion.estado ORDER BY pk_estado";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}		



		function total_reciclaje_municipio($condicion){
			$sql="SELECT (SELECT SUM(cantidad) AS total_material_plastico_k FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=1 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_plastico_t FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=1 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_vidrio_k FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=2 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_vidrio_t FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=2 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_carton_k FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=3 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_carton_t FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=3 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_organico_k FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=4 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_organico_t FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=4 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_papel_k FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=5 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_papel_t FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=5 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_baterias_k FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=6 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_baterias_t FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=6 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_ferroso_k FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=7 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_ferroso_t FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=7 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_textiles_k FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=8 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_textiles_t FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=8 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_neumaticos_k FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=9 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_neumaticos_t FROM sistema.cantidad_reciclaje	INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa INNER JOIN ubicacion.municipio ON sistema.mesas.fk_municipio=ubicacion.municipio.pk_municipio WHERE fk_material=9 AND fk_peso=2 $condicion)";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function consultar_total_reciclaje($condicion){
			$sql="SELECT (SELECT SUM(cantidad) AS total_material_plastico_k FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=1 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_plastico_t FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=1 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_vidrio_k FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=2 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_vidrio_t FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=2 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_carton_k FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=3 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_carton_t FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=3 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_organico_k FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=4 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_organico_t FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=4 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_papel_k FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=5 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_papel_t FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=5 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_baterias_k FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=6 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_baterias_t FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=6 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_ferroso_k FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=7 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_ferroso_t FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=7 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_textiles_k FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=8 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_textiles_t FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=8 AND fk_peso=2 $condicion), (SELECT SUM(cantidad) AS total_material_neumaticos_k FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=9 AND fk_peso=1 $condicion), (SELECT SUM(cantidad) AS total_material_neumaticos_t FROM sistema.cantidad_reciclaje INNER JOIN sistema.mesas ON sistema.cantidad_reciclaje.fk_mesa_cantidad=sistema.mesas.pk_mesa WHERE fk_material=9 AND fk_peso=2 $condicion)";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}

		function consultar_totales_acopio_poblacion(){
			$sql="SELECT (SELECT SUM(poblacion_impactar) AS total_poblacion_impactar FROM sistema.mesas), (SELECT SUM(capacidad_toneladas) AS total_capacidad_toneladas FROM sistema.mesas)";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;			
		}		

		function registrar($nombre_mesa, $estado, $municipio, $parroquia, $usuario, $fk_consejo_comunal, $capacidad_toneladas, $poblacion_impactar){
			$sql="INSERT INTO sistema.mesas (nombre_mesa, fk_estado, fk_municipio, fk_parroquia, fk_usuario, fk_consejo_comunal, capacidad_toneladas, poblacion_impactar) VALUES ('$nombre_mesa', '$estado', '$municipio', '$parroquia', '$usuario', '$fk_consejo_comunal', '$capacidad_toneladas', '$poblacion_impactar') RETURNING pk_mesa";
				$query=pg_query($this->pg_connect, $sql) or die("Error al registrar". pg_last_error());
				return $query;
		}

		function registrar_material($mesa, $usuario, $material, $cantidad, $peso, $metodo_recoleccion, $marca, $placa, $ruta_recoleccion, $fecha){
			$sql="INSERT INTO sistema.cantidad_reciclaje (fk_mesa_cantidad, fk_usuario, fk_material, cantidad, fk_peso, fk_vehiculo, fk_marca, placa, ruta_recoleccion, fecha) VALUES ('$mesa', '$usuario', '$material', '$cantidad', '$peso', '$metodo_recoleccion', '$marca', '$placa', '$ruta_recoleccion', '$fecha')";
				$query=pg_query($this->pg_connect, $sql) or die("Error al registrar". pg_last_error());
				return $query;
		}

		function modificar_material($pk_cantidad_reciclaje, $mesa, $usuario, $material, $cantidad, $peso, $metodo_recoleccion, $marca, $placa, $ruta_recoleccion, $fecha){
			$sql="UPDATE sistema.cantidad_reciclaje SET fk_mesa_cantidad='$mesa', fk_usuario='$usuario', fk_material='$material', cantidad='$cantidad', fk_peso='$peso', fk_vehiculo='$metodo_recoleccion', fk_marca='$marca', placa='$placa', ruta_recoleccion='$ruta_recoleccion', fecha='$fecha' WHERE pk_cantidad_reciclaje='$pk_cantidad_reciclaje'";
			$query=pg_query($this->pg_connect, $sql) or die("Error al modificar". pg_last_error());
				if ($query) {
					return $query;
				}
		}

		function modificar_mesa($pk_mesa, $nombre_mesa, $estado, $municipio, $parroquia, $fk_consejo_comunal, $capacidad_toneladas, $poblacion_impactar){
			$sql="UPDATE sistema.mesas SET nombre_mesa='$nombre_mesa', fk_estado='$estado', fk_municipio='$municipio', fk_parroquia='$parroquia', fk_consejo_comunal='$fk_consejo_comunal', capacidad_toneladas='$capacidad_toneladas', poblacion_impactar='$poblacion_impactar' WHERE pk_mesa='$pk_mesa'";
			$query=pg_query($this->pg_connect, $sql) or die("Error al modificar". pg_last_error());
				if ($query) {
					return $query;
				}
		}

		function eliminar_mesa($tabla, $condicion){
			$sql="DELETE FROM $tabla WHERE $condicion";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}
	}
?>