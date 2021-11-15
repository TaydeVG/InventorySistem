<?php
require_once("../php/objetos/Usuario.php");
include_once("encryption.php");

class ClassAdministradores
{
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
				$datos['mensaje'] = "Administrador registrado con exito!!!";
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
