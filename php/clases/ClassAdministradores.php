<?php
require_once("../php/objetos/Usuario.php");
include_once("encryption.php");

class ClassAdministradores
{
	public static function buscarAdministrador($conexMySql, $pEmail)
	{
		$datos               = array();
		$datos['mensaje']    = "";
		$datos['respuesta']  = array();
		$datos['resultOper'] = 0;

		if ($pEmail) {
			try {

				$sql = "SELECT id,nombre,apellido,correo,password,is_password_random FROM administrador WHERE correo = '$pEmail' LIMIT 1;";
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

					$datos['respuesta'] = $Usuario;
					$datos['mensaje'] = "OK";
					$datos['resultOper'] = 1;
				} else {
					$datos['respuesta'] = $Usuario;
					$datos['mensaje'] = "La direccion de correo no existe.";
					$datos['resultOper'] = 2;
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

	public static function insert($conexMySql, $pUsuario)
	{
		$datos               = array();
		$datos['mensaje']    = "";
		$datos['respuesta']  = array();
		$datos['resultOper'] = 0;

		try {
			$sql = "INSERT INTO administrador(nombre, apellido, correo, password) 
                VALUES ('" . $pUsuario->getNombre() . "','" . $pUsuario->getApellido() . "','" .
				$pUsuario->getCorreo() . "','" . Password::hash($pUsuario->getPassword()) . "');";

			$consulta = $conexMySql->prepare($sql);

			$isSave = $consulta->execute();
			if ($isSave) {
				$datos['respuesta'] = $isSave;
				$datos['mensaje'] = "Usuario registrado con exito!!!";
				$datos['resultOper'] = 1;
			} else {
				$datos['respuesta'] = $isSave;
				$datos['mensaje'] = "Ups... No fue posible guardar la informacion.";
				$datos['resultOper'] = 2;
			}
		} catch (Exception $e) {
			$datos['mensaje'] = $e;
			$datos['resultOper'] = -1;
		}


		return $datos;
	}
	public static function update_password_random($conexMySql, $email, $pass_random)
	{
		$datos               = array();
		$datos['mensaje']    = "";
		$datos['respuesta']  = array();
		$datos['resultOper'] = 0;
		$sql = "";
		try {
			$sql = "UPDATE administrador SET is_password_random = 1, password='" . Password::hash($pass_random) .
				"' WHERE correo = '$email';";

			$consulta = $conexMySql->prepare($sql);

			$isSave = $consulta->execute();
			if ($isSave) {
				$datos['respuesta'] = $isSave;
				$datos['mensaje'] = "Contrase??a actualizada con exito!!!";
				$datos['resultOper'] = 1;
			} else {
				$datos['respuesta'] = $isSave;
				$datos['mensaje'] = "Ups... No fue posible actualizar la constrase??a.";
				$datos['resultOper'] = 2;
			}
		} catch (Exception $e) {
			$datos['mensaje'] = $sql . ":" . $e;
			$datos['resultOper'] = -1;
		}


		return $datos;
	}
	public static function update_password($conexMySql, $email, $password)
	{
		$datos               = array();
		$datos['mensaje']    = "";
		$datos['respuesta']  = array();
		$datos['resultOper'] = 0;
		$sql = "";
		try {
			$sql = "UPDATE administrador SET is_password_random = 0, password='" . Password::hash($password) .
				"' WHERE correo = '$email';";

			$consulta = $conexMySql->prepare($sql);

			$isSave = $consulta->execute();
			if ($isSave) {
				$datos['respuesta'] = $isSave;
				$datos['mensaje'] = "Contrase??a actualizada con exito!!!";
				$datos['resultOper'] = 1;
				$_SESSION["usuario"]->is_password_random = 0;//se setea a 0, el valor is_password_random del usuario de sesion 
				$_SESSION["usuario"]->password = Password::hash($password);//se setea con la nueva contrase??a del usuario de sesion
			} else {
				$datos['respuesta'] = $isSave;
				$datos['mensaje'] = "Ups... No fue posible actualizar la constrase??a.";
				$datos['resultOper'] = 2;
			}
		} catch (Exception $e) {
			$datos['mensaje'] = $sql . ":" . $e;
			$datos['resultOper'] = -1;
		}


		return $datos;
	}
	public static function cerrarSesion()
	{
		$datos               = array();
		$datos['mensaje']    = "Sesion Cerrada";
		$datos['resultOper'] = 1;
		// Finalmente, destruir la sesi??n.
		session_destroy();
		return $datos;
	}
}
