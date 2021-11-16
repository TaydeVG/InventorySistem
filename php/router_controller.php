<?php
session_start();
require "../php/clases/conexion.php";
include_once("../php/objetos/Usuario.php");
include_once("../php/clases/ClassReactivos.php");
include_once("../php/clases/ClassEquipos.php");
include_once("../php/clases/ClassLogin.php");
include_once("../php/clases/ClassRecipientes.php");
include_once("../php/clases/ClassControllerFiles.php");
include_once("../php/clases/ClassAdministradores.php");

$datosRespuesta = array();
$UsuarioRequest = new Usuario();

//obtencion opcion de peticion
$opcion         = isset($_POST['opcion']) ? $_POST['opcion'] : 0;
$opcion         = $opcion != 0 ? $opcion : (isset($_GET['opcion']) ? $_GET['opcion'] : 0);

$idUsuario         = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : 0;
$UsuarioRequest->setId($idUsuario != 0 ? $idUsuario : (isset($_GET['idUsuario']) ? $_GET['idUsuario'] : 0));

$email         = isset($_POST['email']) ? $_POST['email'] : 0;
$UsuarioRequest->setCorreo($email != 0 ? $email : (isset($_GET['email']) ? $_GET['email'] : 0));

$password      = isset($_POST['password']) ? $_POST['password'] : 0;
$UsuarioRequest->setPassword($password != 0 ? $password : (isset($_GET['password']) ? $_GET['password'] : 0));

$apellido      = isset($_POST['apellido']) ? $_POST['apellido'] : 0;
$UsuarioRequest->setApellido($apellido != 0 ? $apellido : (isset($_GET['apellido']) ? $_GET['apellido'] : 0));

$nombre      = isset($_POST['nombre']) ? $_POST['nombre'] : 0;
$UsuarioRequest->setNombre($nombre != 0 ? $nombre : (isset($_GET['nombre']) ? $_GET['nombre'] : 0));

ini_set('memory_limit', '-1');
set_time_limit(0);

//ESTAS DOS LINEAS ES PARA RESOLVER EL PROBLEMA DE LAS Ñ
setlocale(LC_ALL, 'es_ES');
define("CHARSET", "iso-8859-1");

$conexMySql = new Conexion(); //se instancia la clase Conexion para acceder a sus funciones
/* 
estructura para consultas PDO = PHP Data Objects: extensión que provee una capa de abstracción de acceso a datos;
1.- enviar conexion por parametros a funcion: $conexMySql->cnx
2.- una vez ubicaod en la clase, antes de ejecutar la consulta se debe abrir conexion: $conexMySql->conectar();
3.- luego seria preparar la consulta con la conexion recibida por parametro: $consulta = $cnx->prepare("SELECT * FROM tabla");
4.- al preparar la consulta, debajo iria la ejecucion de la funcion: $consulta->execute();
5.- al ejecutar la consulta, para obtener los registros: 
$registros = [];
while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
	$registros[] = $row;
}
6.- una vez obtenida la informacion de base de datos seria, cerrar la conexion:  $cnx->desconectar();
*/

switch ($opcion) {
	case 1:
		$conexMySql->conectar();
		$datosRespuesta = ClassLogin::iniciarSesion($conexMySql->cnx, $UsuarioRequest->getCorreo(), $UsuarioRequest->getPassword());
		$conexMySql->desconectar();
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
	case 6: //subir imagen
		$datosRespuesta = ClassControllerFiles::subirArchivoAlServidor($_FILES['upl'], $UsuarioRequest->getId());
		echo json_encode($datosRespuesta);
		break;
	case 7:
		$conexMySql->conectar();
		$datosRespuesta = ClassAdministradores::insert($conexMySql->cnx, $UsuarioRequest);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 8:
		$conexMySql->conectar();
		$datosRespuesta = ClassLogin::restablecerPassword($conexMySql->cnx, $UsuarioRequest->getCorreo());
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 0:
		$datosRespuesta = ClassLogin::cerrarSesion();
		$conexMySql = null;
		echo json_encode($datosRespuesta);
		break;
}