<?php
session_start();

include_once("../php/objetos/Usuario.php");
include_once("../php/clases/ClassReactivos.php");
include_once("../php/clases/ClassEquipos.php");
include_once("../php/clases/ClassLogin.php");
include_once("../php/clases/ClassRecipientes.php");

$datosRespuesta = array();
$UsuarioRequest = new Usuario();

//obtencion opcion de peticion
$opcion         = isset($_POST['opcion']) ? $_POST['opcion'] : 0;
$opcion         = $opcion != 0 ? $opcion : (isset($_GET['opcion']) ? $_GET['opcion'] : 0);

$email         = isset($_POST['email']) ? $_POST['email'] : 0;
$UsuarioRequest->setEmail($email != 0 ? $email : (isset($_GET['email']) ? $_GET['email'] : 0));

$password      = isset($_POST['password']) ? $_POST['password'] : 0;
$UsuarioRequest->setPassword($password != 0 ? $password : (isset($_GET['password']) ? $_GET['password'] : 0));

ini_set('memory_limit', '-1');
set_time_limit(0);
//ESTAS DOS LINEAS ES PARA RESOLVER EL PROBLEMA DE LAS Ñ
setlocale(LC_ALL, 'es_ES');
define("CHARSET", "iso-8859-1");

$conexMySql = null;

switch ($opcion) {
	case 1:

		$datosRespuesta = ClassLogin::iniciarSesion("conexion", $UsuarioRequest->getEmail(), $UsuarioRequest->getPassword());
		echo json_encode($datosRespuesta);
		break;
	case 2: //obtiene todos los reactivos
		$datosRespuesta = ClassReactivos::getReactivos($conexMySql);
		echo json_encode($datosRespuesta);
		break;
	case 3: //obtiene todos los reactivos
		$datosRespuesta = ClassEquipos::getEquipos($conexMySql);
		echo json_encode($datosRespuesta);
		break;
	case 4: //obtiene todos los reactivos
		$datosRespuesta = ClassRecipientes::getRecipientes($conexMySql);
		echo json_encode($datosRespuesta);
		break;
	case 5: //obtiene los mantenimientos de equipos
		$datosRespuesta = ClassEquipos::getMantenimientos($conexMySql);
		echo json_encode($datosRespuesta);
		break;
	case 0:
		$datosRespuesta = ClassLogin::cerrarSesion();
		echo json_encode($datosRespuesta);
		break;
}
