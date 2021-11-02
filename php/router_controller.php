<?php
    session_start();

	include_once("../php/objetos/Usuario.php");

    $datosRespuesta = array();
	$UsuarioRequest        = new Usuario();

    //obtencion opcion de peticion
	$opcion         = isset($_POST['opcion']) ? $_POST['opcion'] : 0;
	$opcion         = $opcion != 0 ? $opcion : (isset($_GET['opcion']) ? $_GET['opcion'] : 0);

	$email         = isset($_POST['email']) ? $_POST['email'] : 0;
	$UsuarioRequest->setEmail($email != 0 ? $email : (isset($_GET['email']) ? $_GET['email'] : 0));

	$password         = isset($_POST['password']) ? $_POST['password'] : 0;
	$UsuarioRequest->setPassword($password != 0 ? $password : (isset($_GET['password']) ? $_GET['password'] : 0));

    ini_set('memory_limit', '-1');
	set_time_limit(0);	
	//ESTAS DOS LINEAS ES PARA RESOLVER EL PROBLEMA DE LAS Ñ
	setlocale(LC_ALL,'es_ES'); 
	define("CHARSET", "iso-8859-1");

    switch($opcion) 
	{
		case 1:

            $datos               = array();
            $datos['mensaje']    = "Todo bien";
            $datos['resultOper'] = 1;

			$Usuario        = new Usuario();
			$Usuario->setId(1);
			$Usuario->setNombre("Juan");
			$Usuario->setApellido("Perez");
			$Usuario->setEmail($UsuarioRequest->getEmail());
			$Usuario->setPassword($UsuarioRequest->getPassword());
			$Usuario->setId_tipo_usuario(1);

			$datos['respuesta']  = $Usuario;
			//$datosRespuesta = CGenerales::iniciarSesion($conexMySql,$Usuario->getEmail(),$Usuario->getPassword(),$huellaUsuario);
            $datosRespuesta =  $datos;
            
			echo json_encode($datosRespuesta);
			break;
		case 0:
			echo "Opcion Invalida: " . $opcion;
			break;
	}
?>