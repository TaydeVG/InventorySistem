<?php
require "../php/clases/conexion.php";
include_once("../php/objetos/Usuario.php");
include_once("../php/objetos/Equipos.object.php");
include_once("../php/objetos/Recipiente.object.php");
include_once("../php/objetos/Reactivos.object.php");
include_once("../php/clases/ClassReactivos.php");
include_once("../php/clases/ClassEquipos.php");
include_once("../php/clases/ClassLogin.php");
include_once("../php/clases/ClassRecipientes.php");
include_once("../php/clases/ClassAdministradores.php");

session_start(); // se agrega luego de las importaciones para no tener problemas con los arrays en variables de sesion


$datosRespuesta = array();
$UsuarioRequest = new Usuario();
$EquipoRequest = new Equipo();
$RecipienteRequest = new Recipiente();
$ReactivoRequest = new Reactivo();
$MantenimientoRequest = new Mantenimiento();

//obtencion opcion de peticion
$opcion         = isset($_POST['opcion']) ? $_POST['opcion'] : 0;
$opcion         = $opcion != 0 ? $opcion : (isset($_GET['opcion']) ? $_GET['opcion'] : 0);

//obtencion de imagen anterior para el caso de actualizar imagen
$imagen_anterior = isset($_POST['imagen_anterior']) ? $_POST['imagen_anterior'] : null;
$imagen_anterior = $imagen_anterior != null ? $imagen_anterior : (isset($_GET['imagen_anterior']) ? $_GET['imagen_anterior'] : null);



//obtencion de usuario de peticion
$idUsuario         = isset($_POST['idUsuario']) ? $_POST['idUsuario'] : 0;
$UsuarioRequest->setId($idUsuario != 0 ? $idUsuario : (isset($_GET['idUsuario']) ? $_GET['idUsuario'] : 0));

$email         = isset($_POST['email']) ? $_POST['email'] : 0;
$UsuarioRequest->setCorreo($email != 0 ? $email : (isset($_GET['email']) ? $_GET['email'] : ""));

$password      = isset($_POST['password']) ? $_POST['password'] : 0;
$UsuarioRequest->setPassword($password != 0 ? $password : (isset($_GET['password']) ? $_GET['password'] : ""));

$apellido      = isset($_POST['apellido']) ? $_POST['apellido'] : 0;
$UsuarioRequest->setApellido($apellido != 0 ? $apellido : (isset($_GET['apellido']) ? $_GET['apellido'] : ""));

$nombre      = isset($_POST['nombre']) ? $_POST['nombre'] : 0;
$UsuarioRequest->setNombre($nombre != 0 ? $nombre : (isset($_GET['nombre']) ? $_GET['nombre'] : ""));

$is_password_random      = isset($_POST['is_password_random']) ? $_POST['is_password_random'] : 0;
$UsuarioRequest->setIs_password_random($is_password_random != 0 ? $is_password_random : (isset($_GET['is_password_random']) ? $_GET['is_password_random'] : ""));

//obtencion de equipo de peticion
$id_equipo = isset($_POST['id_equipo']) ? $_POST['id_equipo'] : null;
$EquipoRequest->setId($id_equipo != null ? $id_equipo : (isset($_GET['id_equipo']) ? $_GET['id_equipo'] : null));

$nombre_equipo = isset($_POST['nombre_equipo']) ? $_POST['nombre_equipo'] : null;
$EquipoRequest->setNombre($nombre_equipo != null ? $nombre_equipo : (isset($_GET['nombre_equipo']) ? $_GET['nombre_equipo'] : null));

$condicion_uso_equipo = isset($_POST['condicion_uso_equipo']) ? $_POST['condicion_uso_equipo'] : null;
$EquipoRequest->setCondicion_uso($condicion_uso_equipo != null ? $condicion_uso_equipo : (isset($_GET['condicion_uso_equipo']) ? $_GET['condicion_uso_equipo'] : null));

$num_economico_equipo = isset($_POST['num_economico_equipo']) ? $_POST['num_economico_equipo'] : null;
$EquipoRequest->setNum_economico($num_economico_equipo != null ? $num_economico_equipo : (isset($_GET['num_economico_equipo']) ? $_GET['num_economico_equipo'] : null));

$num_serie_equipo = isset($_POST['num_serie_equipo']) ? $_POST['num_serie_equipo'] : null;
$EquipoRequest->setNum_serie($num_serie_equipo != null ? $num_serie_equipo : (isset($_GET['num_serie_equipo']) ? $_GET['num_serie_equipo'] : null));

$id_laboratorio_equipo = isset($_POST['id_laboratorio_equipo']) ? $_POST['id_laboratorio_equipo'] : null;
$EquipoRequest->setId_laboratorio($id_laboratorio_equipo != null ? $id_laboratorio_equipo : (isset($_GET['id_laboratorio_equipo']) ? $_GET['id_laboratorio_equipo'] : null));

$eliminado_equipo = isset($_POST['eliminado_equipo']) ? $_POST['eliminado_equipo'] : null;
$EquipoRequest->setEliminado($eliminado_equipo != null ? $eliminado_equipo : (isset($_GET['eliminado_equipo']) ? $_GET['eliminado_equipo'] : null));

$fecha_baja_equipo = isset($_POST['fecha_baja_equipo']) ? $_POST['fecha_baja_equipo'] : null;
$EquipoRequest->setFecha_baja($fecha_baja_equipo != null ? $fecha_baja_equipo : (isset($_GET['fecha_baja_equipo']) ? $_GET['fecha_baja_equipo'] : null));

$EquipoRequest->setImagen(isset($_FILES['upl']) ? $_FILES['upl'] : null);

//obtencion del Mantenimiento de la peticion
$id_mantenimiento = isset($_POST['id_mantenimiento']) ? $_POST['id_mantenimiento'] : null;
$MantenimientoRequest->setid($id_mantenimiento != null ? $id_mantenimiento : (isset($_GET['id_mantenimiento']) ? $_GET['id_mantenimiento'] : null));

$fecha_mantenimiento_mantenimiento = isset($_POST['fecha_mantenimiento_mantenimiento']) ? $_POST['fecha_mantenimiento_mantenimiento'] : null;
$MantenimientoRequest->setFecha_mantenimiento($fecha_mantenimiento_mantenimiento != null ? $fecha_mantenimiento_mantenimiento : (isset($_GET['fecha_mantenimiento_mantenimiento']) ? $_GET['fecha_mantenimiento_mantenimiento'] : null));

$observaciones_mantenimiento = isset($_POST['observaciones_mantenimiento']) ? $_POST['observaciones_mantenimiento'] : null;
$MantenimientoRequest->setObservaciones($observaciones_mantenimiento != null ? $observaciones_mantenimiento : (isset($_GET['observaciones_mantenimiento']) ? $_GET['observaciones_mantenimiento'] : null));

$id_equipo_mantenimiento = isset($_POST['id_equipo_mantenimiento']) ? $_POST['id_equipo_mantenimiento'] : null;
$MantenimientoRequest->setId_equipo($id_equipo_mantenimiento != null ? $id_equipo_mantenimiento : (isset($_GET['id_equipo_mantenimiento']) ? $_GET['id_equipo_mantenimiento'] : null));

$eliminado_mantenimiento = isset($_POST['eliminado_mantenimiento']) ? $_POST['eliminado_mantenimiento'] : null;
$MantenimientoRequest->seteliminado($eliminado_mantenimiento != null ? $eliminado_mantenimiento : (isset($_GET['eliminado_mantenimiento']) ? $_GET['eliminado_mantenimiento'] : null));

//obtencion de reacipiente de la peticion
$id_recipiente = isset($_POST['id_recipiente']) ? $_POST['id_recipiente'] : null;
$RecipienteRequest->setId($id_recipiente != null ? $id_recipiente : (isset($_GET['id_recipiente']) ? $_GET['id_recipiente'] : null));

$nombre_recipiente = isset($_POST['nombre_recipiente']) ? $_POST['nombre_recipiente'] : null;
$RecipienteRequest->setNombre($nombre_recipiente != null ? $nombre_recipiente : (isset($_GET['nombre_recipiente']) ? $_GET['nombre_recipiente'] : null));

$id_tipo_material_recipiente = isset($_POST['id_tipo_material_recipiente']) ? $_POST['id_tipo_material_recipiente'] : null;
$RecipienteRequest->setId_tipo_material($id_tipo_material_recipiente != null ? $id_tipo_material_recipiente : (isset($_GET['id_tipo_material_recipiente']) ? $_GET['id_tipo_material_recipiente'] : null));

$nombre_tipo_material_recipiente = isset($_POST['nombre_tipo_material_recipiente']) ? $_POST['nombre_tipo_material_recipiente'] : null;
$RecipienteRequest->setNombre_tipo_material($nombre_tipo_material_recipiente != null ? $nombre_tipo_material_recipiente : (isset($_GET['nombre_tipo_material_recipiente']) ? $_GET['nombre_tipo_material_recipiente'] : null));

$capacidad_recipiente = isset($_POST['capacidad_recipiente']) ? $_POST['capacidad_recipiente'] : null;
$RecipienteRequest->setCapacidad($capacidad_recipiente != null ? $capacidad_recipiente : (isset($_GET['capacidad_recipiente']) ? $_GET['capacidad_recipiente'] : null));

$id_laboratorio_recipiente = isset($_POST['id_laboratorio_recipiente']) ? $_POST['id_laboratorio_recipiente'] : null;
$RecipienteRequest->setId_laboratorio($id_laboratorio_recipiente != null ? $id_laboratorio_recipiente : (isset($_GET['id_laboratorio_recipiente']) ? $_GET['id_laboratorio_recipiente'] : null));

$eliminado_recipiente = isset($_POST['eliminado_recipiente']) ? $_POST['eliminado_recipiente'] : null;
$RecipienteRequest->setEliminado($eliminado_recipiente != null ? $eliminado_recipiente : (isset($_GET['eliminado_recipiente']) ? $_GET['eliminado_recipiente'] : null));

$fecha_baja_recipiente = isset($_POST['fecha_baja_recipiente']) ? $_POST['fecha_baja_recipiente'] : null;
$RecipienteRequest->setFecha_baja($fecha_baja_recipiente != null ? $fecha_baja_recipiente : (isset($_GET['fecha_baja_recipiente']) ? $_GET['fecha_baja_recipiente'] : null));

$RecipienteRequest->setImagen(isset($_FILES['upl']) ? $_FILES['upl'] : null);

//obtencion de reactivos de la peticion
$id_reactivo = isset($_POST['id_reactivo']) ? $_POST['id_reactivo'] : null;
$ReactivoRequest->setId($id_reactivo != null ? $id_reactivo : (isset($_GET['id_reactivo']) ? $_GET['id_reactivo'] : null));

$nombre_reactivo = isset($_POST['nombre_reactivo']) ? $_POST['nombre_reactivo'] : null;
$ReactivoRequest->setNombre($nombre_reactivo != null ? $nombre_reactivo : (isset($_GET['nombre_reactivo']) ? $_GET['nombre_reactivo'] : null));

$reactividad_reactivo = isset($_POST['reactividad_reactivo']) ? $_POST['reactividad_reactivo'] : null;
$ReactivoRequest->setReactividad($reactividad_reactivo != null ? $reactividad_reactivo : (isset($_GET['reactividad_reactivo']) ? $_GET['reactividad_reactivo'] : null));

$inflamabilida_reactivo = isset($_POST['inflamabilida_reactivo']) ? $_POST['inflamabilida_reactivo'] : null;
$ReactivoRequest->setInflamabilida($inflamabilida_reactivo != null ? $inflamabilida_reactivo : (isset($_GET['inflamabilida_reactivo']) ? $_GET['inflamabilida_reactivo'] : null));

$riesgoSalud_reactivo = isset($_POST['riesgoSalud_reactivo']) ? $_POST['riesgoSalud_reactivo'] : null;
$ReactivoRequest->setRiesgo_salud($riesgoSalud_reactivo != null ? $riesgoSalud_reactivo : (isset($_GET['riesgoSalud_reactivo']) ? $_GET['riesgoSalud_reactivo'] : null));

$presentacion_reactivo = isset($_POST['presentacion_reactivo']) ? $_POST['presentacion_reactivo'] : null;
$ReactivoRequest->setPresentacion($presentacion_reactivo != null ? $presentacion_reactivo : (isset($_GET['presentacion_reactivo']) ? $_GET['presentacion_reactivo'] : null));

$nReactivo_reactivo = isset($_POST['nReactivo_reactivo']) ? $_POST['nReactivo_reactivo'] : null;
$ReactivoRequest->setCantidad($nReactivo_reactivo != null ? $nReactivo_reactivo : (isset($_GET['nReactivo_reactivo']) ? $_GET['nReactivo_reactivo'] : null));

$unidadMedida_reactivo = isset($_POST['unidadMedida_reactivo']) ? $_POST['unidadMedida_reactivo'] : null;
$ReactivoRequest->setUnidad_medida($unidadMedida_reactivo != null ? $unidadMedida_reactivo : (isset($_GET['unidadMedida_reactivo']) ? $_GET['unidadMedida_reactivo'] : null));

$codigoAlmacenamiento_reactivo = isset($_POST['codigoAlmacenamiento_reactivo']) ? $_POST['codigoAlmacenamiento_reactivo'] : null;
$ReactivoRequest->setCodigo_almacenamiento($codigoAlmacenamiento_reactivo != null ? $codigoAlmacenamiento_reactivo : (isset($_GET['codigoAlmacenamiento_reactivo']) ? $_GET['codigoAlmacenamiento_reactivo'] : null));

$caducidad_reactivo = isset($_POST['caducidad_reactivo']) ? $_POST['caducidad_reactivo'] : null;
$ReactivoRequest->setCaducidad($caducidad_reactivo != null ? $caducidad_reactivo : (isset($_GET['caducidad_reactivo']) ? $_GET['caducidad_reactivo'] : null));

$nMueble_reactivo = isset($_POST['nMueble_reactivo']) ? $_POST['nMueble_reactivo'] : null;
$ReactivoRequest->setN_mueble($nMueble_reactivo != null ? $nMueble_reactivo : (isset($_GET['nMueble_reactivo']) ? $_GET['nMueble_reactivo'] : null));

$nEstante_reactivo = isset($_POST['nEstante_reactivo']) ? $_POST['nEstante_reactivo'] : null;
$ReactivoRequest->setN_estante($nEstante_reactivo != null ? $nEstante_reactivo : (isset($_GET['nEstante_reactivo']) ? $_GET['nEstante_reactivo'] : null));

$id_laboratorio_reactivo = isset($_POST['id_laboratorio_reactivo']) ? $_POST['id_laboratorio_reactivo'] : null;
$ReactivoRequest->setId_laboratorio($id_laboratorio_reactivo != null ? $id_laboratorio_reactivo : (isset($_GET['id_laboratorio_reactivo']) ? $_GET['id_laboratorio_reactivo'] : null));

$eliminado_reactivo = isset($_POST['eliminado_reactivo']) ? $_POST['eliminado_reactivo'] : null;
$ReactivoRequest->setEliminado($eliminado_reactivo != null ? $eliminado_reactivo : (isset($_GET['eliminado_reactivo']) ? $_GET['eliminado_reactivo'] : null));

$fecha_baja_reactivo = isset($_POST['fecha_baja_reactivo']) ? $_POST['fecha_baja_reactivo'] : null;
$ReactivoRequest->setFecha_baja($fecha_baja_reactivo != null ? $fecha_baja_reactivo : (isset($_GET['fecha_baja_reactivo']) ? $_GET['fecha_baja_reactivo'] : null));


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
	case 6: //insert recipiente
		$conexMySql->conectar();
		$datosRespuesta = ClassRecipientes::insert($conexMySql->cnx, $RecipienteRequest);
		$conexMySql->desconectar();
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
		$tiempo_para_caducar = isset($_POST['tiempo_para_caducar']) ? $_POST['tiempo_para_caducar'] : '7 DAY';

		$conexMySql->conectar();
		$datosRespuesta = ClassReactivos::getReactivosPorCaducar($conexMySql->cnx, $tiempo_para_caducar);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 13: //obtiene todos los reactivos
		$conexMySql->conectar();
		$datosRespuesta = ClassReactivos::getReactivos_eliminados($conexMySql->cnx);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 14: //obtiene todos los reactivos
		$conexMySql->conectar();
		$datosRespuesta = ClassEquipos::getEquipos_eliminados($conexMySql->cnx);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 15: //obtiene todos los reactivos
		$conexMySql->conectar();
		$datosRespuesta = ClassRecipientes::getRecipientes_eliminados($conexMySql->cnx);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 16: //obtiene todos los reactivos
		$conexMySql->conectar();
		$datosRespuesta = ClassRecipientes::getTipo_materiales($conexMySql->cnx);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 17: //inserta un reactivos
		$conexMySql->conectar();
		$datosRespuesta = ClassReactivos::insert($conexMySql->cnx, $ReactivoRequest);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 18: //agregar equipo
		$conexMySql->conectar();
		$datosRespuesta = ClassEquipos::insert($conexMySql->cnx, $EquipoRequest);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 19: //obtiene todos los laboratorios
		$conexMySql->conectar();
		$datosRespuesta = ClassEquipos::getLaboratorios($conexMySql->cnx);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 20: //guardar mantenimiento
		$conexMySql->conectar();
		$datosRespuesta = ClassEquipos::insert_mantenimiento($conexMySql->cnx, $MantenimientoRequest);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 21: //actualiza un reactivo
		$conexMySql->conectar();
		$datosRespuesta = ClassReactivos::update($conexMySql->cnx, $ReactivoRequest);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 22: //actualiza el estatus eliminado a 1 a un reactivo
		$conexMySql->conectar();
		$datosRespuesta = ClassReactivos::delete($conexMySql->cnx, $ReactivoRequest->getId());
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 23: //actualizar equipo
		$conexMySql->conectar();
		$datosRespuesta = ClassEquipos::update($conexMySql->cnx, $EquipoRequest, $imagen_anterior);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 24: //eliminar equipo
		$conexMySql->conectar();
		$datosRespuesta = ClassEquipos::delete($conexMySql->cnx, $EquipoRequest->getId());
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 25: //actualizar recipiente
		$conexMySql->conectar();
		$datosRespuesta = ClassRecipientes::update($conexMySql->cnx, $RecipienteRequest, $imagen_anterior);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 26: //eliminar equipo
		$conexMySql->conectar();
		$datosRespuesta = ClassRecipientes::delete($conexMySql->cnx, $RecipienteRequest->getId());
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 27: //actualizar mantenimiento
		$conexMySql->conectar();
		$datosRespuesta = ClassEquipos::update_mantenimiento($conexMySql->cnx, $MantenimientoRequest);
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 28: //eliminar mantenimiento
		$conexMySql->conectar();
		$datosRespuesta = ClassEquipos::delete_mantenimiento($conexMySql->cnx, $MantenimientoRequest->getId());
		$conexMySql->desconectar();
		echo json_encode($datosRespuesta);
		break;
	case 0:
		$datosRespuesta = ClassLogin::cerrarSesion();
		$conexMySql = null;
		echo json_encode($datosRespuesta);
		break;
}
