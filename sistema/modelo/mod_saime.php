<?php

	require_once "../../sistema/modelo/mod_conexion_saime.php";

	class saime extends conexion_saime{
		private $idpersona;
	    private $cedula;
	    private $primer_nombre;
	    private $segundo_nombre;	    
	    private $primer_apellido;
	    private $segundo_apellido;	    
	    private $sexo;
	    private $fecha_nacimiento;
	    private $idestado_civil;	    
		private $pg_connect;

		function __construct(){
			parent::__construct();
			$this->pg_connect=parent::conectar_saime();
		}
		
		function consultar($tabla, $campos, $enlace, $condicion){
			$sql="SELECT $campos FROM $tabla $enlace WHERE $condicion";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;
		}
	}
?>