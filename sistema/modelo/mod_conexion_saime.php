<?php
	class conexion_saime{

		private $user;
		private $password;
		private $server;
		private $port;
		private $database;
		private $conex;


		function __construct(){
			$this->user='postgres';
			$this->password='postgres';
			$this->server='localhost';
			$this->port='5432';
			$this->database='vsaime';
			$this->conex='';
		}


		function conectar_saime(){
			$this->conex=pg_connect("host=$this->server port=$this->port password=$this->password user=$this->user dbname=$this->database")or die("Error de Conexion".pg_last_error());
			return $this->conex;
		}
	}

	$obj_conexion=new conexion_saime();
	$funcion_conectar=$obj_conexion->conectar_saime();
?>