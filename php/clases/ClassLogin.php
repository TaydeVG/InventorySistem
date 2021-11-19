<?php
require_once("../php/objetos/Usuario.php");
require_once("ClassAdministradores.php");
include_once("encryption.php");

class ClassLogin
{
	public static function iniciarSesion($conexMySql, $pEmail, $pPassword)
	{
		$datos               = array();
		$datos['mensaje']    = "";
		$datos['respuesta']  = array();
		$datos['resultOper'] = 0;

		if ($pEmail && $pPassword) {
			try {

				$sql = "SELECT id,nombre,apellido,correo,password,is_password_random FROM administrador WHERE correo = '$pEmail' and password = '" .
					Password::hash($pPassword) . "' LIMIT 1;";
				$consulta = $conexMySql->prepare($sql);
				$consulta->execute();

				$Usuario = new Usuario();
				while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
					$Usuario->setId($row->id);
					$Usuario->setNombre($row->nombre);
					$Usuario->setApellido($row->apellido);
					$Usuario->setCorreo($row->correo);
					$Usuario->setPassword($row->password);
					$Usuario->setIs_password_random($row->is_password_random);
				}

				if ($Usuario != null && $Usuario->getId() != null && $Usuario->getId() != 0) {

					$_SESSION["usuario"] = $Usuario;

					$datos['respuesta'] = $Usuario;
					$datos['mensaje'] = "Bienvenido " . $Usuario->getNombre() . ".";
					$datos['resultOper'] = 1;
				} else {
					$datos['respuesta'] = $Usuario;
					$datos['mensaje'] = "Ups... Usuario o contraseña incorrectos!";
					$datos['resultOper'] = 2;
					$_SESSION["usuario"] = null;
				}
			} catch (Exception $e) {
				$datos['mensaje'] = $e;
				$datos['resultOper'] = -1;
			}
		} else {
			$datos['mensaje'] = "BAD REQUEST";
		}
		return $datos;
	}
	public static function cerrarSesion()
	{
		$datos               = array();
		$datos['mensaje']    = "Sesion Cerrada";
		$datos['resultOper'] = 1;
		// Finalmente, destruir la sesión.
		session_destroy();
		return $datos;
	}
	public static function restablecerPassword($conexMySql, $mail)
	{
		/* video tutorial de configuracion para envio de email
		https://www.youtube.com/watch?v=1uWV13gHwQc&ab_channel=FelipeGamer2751
		*/
		$datos               = array();
		$datos['mensaje']    = "";
		$datos['respuesta']  = array();
		$datos['resultOper'] = 0;
		$resp = array();

		/* 
		se crea contraseña random en base a la fecha actual, agregandole el encripado y recortandolo a
		de 8 caracteres
		*/
		$passwordRandom = substr(Password::hash(getdate()['0']), 0, 8);

		try {
			$validUsuario = ClassAdministradores::buscarAdministrador($conexMySql, $mail);
			if ($validUsuario['resultOper'] == 1) {

				$resp = ClassAdministradores::update_password_random($conexMySql, $mail, $passwordRandom);

				if ($resp['resultOper'] == 1) {

					$para      = $mail;
					$titulo    = 'Contraseña Restablecida';
					$mensaje = '
			<!doctype html>
			<html lang="en">
			<head>
				<!-- Required meta tags -->
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">

				<!-- Bootstrap CSS -->
				<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
			</head>
			<body>
					<div>
						<h4> <img style="width: 210px; "
						class="animated zoomIn shadow-lg position-absolute top-50 start-50 translate-middle border border-5 rounded p-3"
						src="https://admin.google.com/u/1/ac/images/logo.gif?uid=109516714961424956204&service=google_gsuite" alt=""></h4>
					</div>
					<div><h1><b>InventorySistem</b></h1></div>
					<div><hr></div>
					<div>
						<h3>Hola ' . $validUsuario["respuesta"]->nombre . ', se solicitó un restablecimiento de contraseña para tu cuenta en <b>InventorySistem</b></h3>
					</div>
					<div><h3><b>Contraseña nueva:</b> ' . $passwordRandom . '</h3></div>
					<div>
						<h3>
							<a href="http://localhost:8080/InventorySistem" target="_blank" rel="noopener noreferrer">ir al sitio</a>
						</h3>
					</div>
					
				</body>
			</html>';
					$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
					$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$success = mail($para, $titulo, $mensaje, $cabeceras);

					if ($success) {
						$datos['mensaje']    = "Se a enviado tu nueva contraseña al correo proporcionado!";
						$datos['resultOper'] = 1;
					} else {
						$datos['mensaje'] = "Ups, no fue posible enviar el correo con la nueva contraseña, " . $success;
						$datos['resultOper'] = 2;
					}
				} else {
					$datos['mensaje'] = "Ups, no fue posible restablecer la contraseña, " . $resp['mensaje'];
					$datos['resultOper'] = 3;
				}
			} else {
				$datos['mensaje'] = $validUsuario['mensaje'];
				$datos['resultOper'] = 4;
			}
		} catch (Exception $e) {
			$datos['mensaje'] = $e;
			$datos['resultOper'] = -1;
		}

		return $datos;
	}
}
