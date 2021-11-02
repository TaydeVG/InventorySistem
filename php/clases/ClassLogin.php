<?php
require_once("../objetos/Usuario.php");

class ClassLogin 
{
    function iniciarSesion($conexMySql,$pEmail,$pPassword)
	{
        $datos               = array();
		$datos['mensaje']    = "";
		$datos['respuesta']  = 0;
		$datos['resultOper'] = 0;

        if (($pEmail != "" && $pPassword != "") || ($pEmail != "" && $huellaUsuario != "") ) 
		{
            $cSql = "SELECT id,nombre,apellido,email,password,id_tipo_usuario FROM  usuarios where email LIKE '$pEmail%' LIMIT 1;";

            try 
			{
                $Usuario = new Usuario;

                foreach ($conexMySql->query($cSql) as $Resultado) 
				{
                    $Usuario->setId($Resultado['id']);
					$Usuario->setNombre($Resultado['nombre']);
					$Usuario->setApellido($Resultado['apellido']);
					$Usuario->setEmail($Resultado['email']);
					$Usuario->setPassword($Resultado['password']);
					$Usuario->setId_tipo_usuario($Resultado['id_tipo_usuario']);

                }

                if ($Usuario != null && $Usuario->getId() != null && $Usuario->getId() != 0) 
				{
                    $datos['mensaje'] = "Bienvenido!.";
                    $datos['respuesta'] = $Usuario;
                    $datos['resultOper'] = 1;
				
				}
				else
				{
					$datos['respuesta'] = $Usuario;
					$datos['mensaje'] = "Datos Incorrectos!.";
					$datos['resultOper'] = 2;
				}
            } catch (Exception $e) {
				$datos['mensaje'] = $e;
				$datos['resultOper'] = -1;
			}
        }
        return $datos;	
    }
}
?>