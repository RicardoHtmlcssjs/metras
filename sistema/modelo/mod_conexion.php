<?php
	class conexion{

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
			$this->port='5433';
			$this->database='mesas_reciclaje';
			$this->conex='';
		}


		function conectar(){
			$this->conex=pg_connect("host=$this->server port=$this->port password=$this->password user=$this->user dbname=$this->database")or die("Error de Conexion".pg_last_error());
			return $this->conex;
		}
	}

	$obj_conexion=new conexion();
	$funcion_conectar=$obj_conexion->conectar();
?>