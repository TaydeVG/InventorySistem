<?php
require "../php/clases/conexion.php";
include_once("../php/objetos/Usuario.php");
include_once("../php/objetos/Equipos.object.php");
include_once("../php/clases/ClassReactivos.php");
include_once("../php/clases/ClassEquipos.php");
include_once("../php/clases/ClassLogin.php");
include_once("../php/clases/ClassRecipientes.php");
include_once("../php/clases/ClassControllerFiles.php");
include_once("../php/clases/ClassAdministradores.php");

session_start(); // se agrega luego de las importaciones para no tener problemas con los arrays en variables de sesion


$datosRespuesta = array();
$UsuarioRequest = new Usuario();
$EquipoRequest = new Equipo();

//obtencion opcion de peticion
$opcion         = isset($_POST['opcion']) ? $_POST['opcion'] : 0;
$opcion         = $opcion != 0 ? $opcion : (isset($_GET['opcion']) ? $_GET['opcion'] : 0);

//obtencion de usuario de peticion
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

$is_password_random      = isset($_POST['is_password_random']) ? $_POST['is_password_random'] : 0;
$UsuarioRequest->setIs_password_random($is_password_random != 0 ? $is_password_random : (isset($_GET['is_password_random']) ? $_GET['is_password_random'] : 0));

//obtencion de equipo de peticion
$id_equipo      = isset($_POST['id_equipo']) ? $_POST['id_equipo'] : 0;
$EquipoRequest->setId($id_equipo != 0 ? $id_equipo : (isset($_GET['id_equipo']) ? $_GET['id_equipo'] : 0));
ini_set('memory_limit', '-1');
set_time_limit(0);

//ESTAS DOS LINEAS ES PARA RESOLVER EL PROBLEMA DE LAS Ñ
setlocale(LC_ALL, 'es_ES');
define("CHARSET", "iso-8859-1");

$conexMySql = new Conexion(); //se instancia la clase Conexion para acceder a sus funciones
/* 
estructura para consultas PDO = PHP Data Objects: extensión que provee una capa de abstracción de acceso a datos;
1.- abrir conexion, antes de enviar como parametro a la clase: $conexMySql->conectar();
2.- enviar conexion por parametros a funcion: $conexMySql->cnx
3.- dentro de la funcion a la que se le paso la conexion como parametro, 
	lo primero es preparar la consulta: $consulta = $conexMySql->prepare("SELECT * FROM tabla");
4.- al preparar la consulta, debajo iria la ejecucion de la funcion: $consulta->execute();
5.- al ejecutar la consulta, para obtener los registros: 
$registros = [];
while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
	$registros[] = $row;
}
6.- una vez obtenida la informacion de base de datos seria, cerrar la conexion en el archivo que abrio la conxion: $conexMySql->desconectar();
*/

switch ($opcion) {
	case 1:
		$conexMySql->conectar();
		$datosRespuesta = ClassLogin::iniciarSesion($conexMySql->cnx, $UsuarioRequest->getCorreo(), $UsuarioRequest->getPassword());
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 2: //obtiene todos los reactivos
		$conexMySql->conectar();
		$datosRespuesta = ClassReactivos::getReactivos($conexMySql->cnx);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 3: //obtiene todos los reactivos
		$conexMySql->conectar();
		$datosRespuesta = ClassEquipos::getEquipos($conexMySql->cnx);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 4: //obtiene todos los reactivos
		$conexMySql->conectar();
		$datosRespuesta = ClassRecipientes::getRecipientes($conexMySql->cnx);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 5: //obtiene los mantenimientos de equipos
		$conexMySql->conectar();
		$datosRespuesta = ClassEquipos::getMantenimientos($conexMySql->cnx, $EquipoRequest->getId());
		$conexMySql->desconectar();
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
	case 9:
		$conexMySql->conectar();
		$datosRespuesta = ClassAdministradores::update_password($conexMySql->cnx, $_SESSION["usuario"]->correo, $UsuarioRequest->getPassword());
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 10:
		echo json_encode($_SESSION["usuario"]);
		break;
	case 11: //obtiene todos los reactivos
		$conexMySql->conectar();
		$datosRespuesta = ClassReactivos::getReactivosCaducados($conexMySql->cnx);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 12: //obtiene todos los reactivos por caducar en un intervalo de tiempo, 1 semana,1 mes, 3 meses, 6 meses, 1 año

		//si no viene un valor por defecto mostrara los que faltan por caducar en 1 semana
		$tiempo_para_caducar         = isset($_POST['tiempo_para_caducar']) ? $_POST['tiempo_para_caducar'] : '7 DAY';

		$conexMySql->conectar();
		$datosRespuesta = ClassReactivos::getReactivosPorCaducar($conexMySql->cnx, $tiempo_para_caducar);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 0:
		$datosRespuesta = ClassLogin::cerrarSesion();
		$conexMySql = null;
		echo json_encode($datosRespuesta);
		break;
}
