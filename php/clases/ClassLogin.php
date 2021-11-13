<?php
require_once("../php/objetos/Usuario.php");
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
			//	$pPassword           = Password::hash($pPassword);
			try {
				$sql = "SELECT id,nombre,apellido,correo,password FROM administrador WHERE correo = '$pEmail' and password = '$pPassword' LIMIT 1;";
				$consulta = $conexMySql->prepare($sql);
				$consulta->execute();

				$Usuario = new Usuario();
				while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
					$Usuario->setId($row->id);
					$Usuario->setNombre($row->nombre);
					$Usuario->setApellido($row->apellido);
					$Usuario->setCorreo($row->correo);
					$Usuario->setPassword($row->password);
				}

				if ($Usuario != null && $Usuario->getId() != null && $Usuario->getId() != 0) {

					$_SESSION["usuario"] = $Usuario;

					$datos['respuesta'] = $Usuario;
					$datos['mensaje'] = "Bienvenido " . $Usuario->getNombre() . ".";
					$datos['resultOper'] = 1;
				} else {
					$datos['respuesta'] = $Usuario;
					$datos['mensaje'] = "Datos Incorrectos!.";
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
	public static function cerrarSesion()
	{
		$datos               = array();
		$datos['mensaje']    = "Sesion Cerrada";
		$datos['resultOper'] = 1;
		// Finalmente, destruir la sesión.
		session_destroy();
		return $datos;
	}
}
