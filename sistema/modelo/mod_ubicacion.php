<?php
	require_once "mod_conexion.php";

	class ubicacion extends conexion{

		private $pg_connect;

		function __construct(){
			parent::__construct();
			$this->pg_connect=parent::conectar();
		}
		
		function consultar($tabla, $condicion){
			$sql="SELECT * FROM $tabla WHERE $condicion";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}
	}
?>