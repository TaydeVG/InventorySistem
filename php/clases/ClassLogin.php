<?php
require_once("../php/objetos/Usuario.php");

class ClassLogin
{
	public static function iniciarSesion($conexMySql, $pEmail, $pPassword)
	{
		$datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

			$cSql = "SELECT id,nombre,apellido,email,password,id_tipo_usuario FROM  usuarios where email LIKE '$pEmail%' LIMIT 1;";

			try {
				$Usuario        = new Usuario();
				$Usuario->setId(1);
				$Usuario->setNombre("ejemplo nombre");
				$Usuario->setApellido("ejemplo apellido");
				$Usuario->setCorreo($pEmail);
				$Usuario->setPassword($pPassword);

				$_SESSION["usuario"] = $Usuario; 
				
				$datos['respuesta'] = $Usuario;
				$datos['mensaje'] = "Datos de sesion correctos.";
				$datos['resultOper'] = 1;
				/* foreach ($conexMySql->query($cSql) as $Resultado) {
					$Usuario->setId($Resultado['id']);
					$Usuario->setNombre($Resultado['nombre']);
					$Usuario->setApellido($Resultado['apellido']);
					$Usuario->setEmail($Resultado['email']);
					$Usuario->setPassword($Resultado['password']);
					$Usuario->setId_tipo_usuario($Resultado['id_tipo_usuario']);
				}

				if ($Usuario != null && $Usuario->getId() != null && $Usuario->getId() != 0) {
					$datos['mensaje'] = "Bienvenido!.";
					$datos['respuesta'] = $Usuario;
					$datos['resultOper'] = 1;
				} else {
					$datos['respuesta'] = $Usuario;
					$datos['mensaje'] = "Datos Incorrectos!.";
					$datos['resultOper'] = 2;
				} */
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
		return $datos ;
	}
}
