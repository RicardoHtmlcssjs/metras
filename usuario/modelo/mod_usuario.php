<?php
	require_once "../../sistema/modelo/mod_conexion.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class usuarios extends conexion{
		private $pk_usuario;
	    private $cedula;
	    private $nombre;
	    private $apellido;
	    private $correo;
	    private $telefono;
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

		function verificar_duplicidad($valor1, $valor2, $valor3){
			$sql="SELECT cedula FROM seguridad.usuarios WHERE cedula='$valor1' OR correo='$valor2' OR telefono='$valor3'";
			$query=pg_query($this->pg_connect, $sql) or die("Error al consultar". pg_last_error());
			return $query;			
		}

		function registrar($nacionalidad, $cedula, $nombre, $apellido, $genero, $edad, $nivel_academico, $usuario, $contrasena, $correo, $telefono, $privilegio, $estatus){
			$sql="INSERT INTO seguridad.usuarios (fk_nacionalidad, cedula, nombre, apellido, genero, edad, fk_nivel_academico, nombre_usuario, contrasena, correo, telefono, fk_privilegio, fk_estatus) VALUES ('$nacionalidad', '$cedula', '$nombre', '$apellido', '$genero', '$edad', '$nivel_academico', '$usuario', '$contrasena', '$correo', '$telefono', '$privilegio', '$estatus') RETURNING pk_usuario";
				$query=pg_query($this->pg_connect, $sql) or die("Error al registrar". pg_last_error());
				return $query;
		}

		function modificar($pk_usuario, $nacionalidad, $cedula, $nombre, $apellido, $genero, $edad, $nivel_academico, $usuario, $correo, $telefono){
			$sql="UPDATE seguridad.usuarios SET fk_nacionalidad='$nacionalidad', cedula='$cedula', nombre='$nombre', apellido='$apellido', genero='$genero', edad='$edad', fk_nivel_academico='$nivel_academico', nombre_usuario='$usuario', correo='$correo', telefono='$telefono' WHERE pk_usuario='$pk_usuario'";
			$query=pg_query($this->pg_connect, $sql) or die("Error al modificar". pg_last_error());
				if ($query) {
					return $query;
				}
		}

		function modificar_clave($cedula, $contrasena){
			$sql="UPDATE seguridad.usuarios SET contrasena='$contrasena' WHERE cedula='$cedula'";
			$query=pg_query($this->pg_connect, $sql) or die("Error al modificar". pg_last_error());
				if ($query) {
					return $query;
				}
		}

		function modificar_fk($fk_usuario, $fk_mesa){
			$sql="UPDATE seguridad.usuarios SET fk_mesa='$fk_mesa' WHERE pk_usuario='$fk_usuario'";
			$query=pg_query($this->pg_connect, $sql) or die("Error al modificar". pg_last_error());
				if ($query) {
					return $query;
				}
		}

		function enviar_correo($destinatario, $nombre, $asunto, $mensaje){
			require '../../vendor/autoload.php';

			$mail = new PHPMailer(true);

			try {
			    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
			    $mail->isSMTP();
			    $mail->Host = 'smtp.gmail.com';
			    $mail->SMTPAuth = true;
			    $mail->Username = 'sistemasoticminec@gmail.com';
			    $mail->Password = 'japhfugkvfnaoplj';
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			    $mail->Port = 587;

			    $mail->setFrom('sistemasoticminec@gmail.com', 'Minec');
			    $mail->addAddress("$destinatario", "$nombre");
			    //$mail->addCC("$destinatario");

			    //$mail->addAttachment('../../docs/dashboard.png', 'Dashboard.png');

			    $mail->isHTML(true);
			    $mail->Subject = "$asunto";
			    $mail->Body = "$mensaje";
			    $mail->send();

			    //echo 'Correo enviado';
			} catch (Exception $e) {
			    echo 'Mensaje ' . $mail->ErrorInfo;
			}
		}		
		
	}
?>