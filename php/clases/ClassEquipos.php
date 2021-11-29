<?php
require_once("../php/objetos/Equipos.object.php");
include_once("../php/clases/ClassControllerFiles.php");

class ClassEquipos
{
    public static function insert($conexMySql, $equipoReq)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {
            $nombre_imagen = null;
            if ($equipoReq->getImagen()) { //si viene una imagen se renombra la imagen
                $nombre_original = $equipoReq->getImagen()['name'];
                $estructura = explode(".", $nombre_original);
                $extencion = $estructura[count($estructura) - 1];
                $nombre_imagen = getdate()['0'] . "." . $extencion;
                $sql = "INSERT INTO equipo(nombre, condicion_uso, num_economico, num_serie, id_laboratorio,imagen)
                    VALUES ('" . $equipoReq->getNombre() . "','" . $equipoReq->getCondicion_uso() . "'," .
                    $equipoReq->getNum_economico() . ",'" . $equipoReq->getNum_serie() . "'," . $equipoReq->getId_laboratorio() .
                    ",'$nombre_imagen');";
            } else {
                $sql = "INSERT INTO equipo(nombre, condicion_uso, num_economico, num_serie, id_laboratorio)
                VALUES ('" . $equipoReq->getNombre() . "','" . $equipoReq->getCondicion_uso() . "'," .
                    $equipoReq->getNum_economico() . ",'" . $equipoReq->getNum_serie() . "'," . $equipoReq->getId_laboratorio() .
                    ");";
            }

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Equipo registrado con exito!!! ";
                $datos['resultOper'] = 1;
                if ($equipoReq->getImagen()) { //si viene una imagen se renombra la imagen
                    $resultSave = ClassControllerFiles::subirArchivoAlServidor(null, $_FILES['upl'], $nombre_imagen, "equipos");
                    $datos['mensaje'] .=  $resultSave['mensaje'];
                }
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
    public static function update($conexMySql, $equipoReq, $imagen_anterior)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {
            $nombre_imagen = null;
            if ($equipoReq->getImagen()) { //si viene una imagen se renombra la imagen
                $nombre_original = $equipoReq->getImagen()['name'];
                $estructura = explode(".", $nombre_original);
                $extencion = $estructura[count($estructura) - 1];
                $nombre_imagen = getdate()['0'] . "." . $extencion;
                $sql = "UPDATE equipo SET nombre= '" . $equipoReq->getNombre() . "', condicion_uso= '" . $equipoReq->getCondicion_uso() .
                    "', num_economico= " . $equipoReq->getNum_economico() . ", num_serie= '" . $equipoReq->getNum_serie() .
                    "', id_laboratorio= " . $equipoReq->getId_laboratorio() . ", imagen= '" . $nombre_imagen .
                    "' WHERE id = " . $equipoReq->getId() . ";";
            } else {
                $sql = "UPDATE equipo SET nombre= '" . $equipoReq->getNombre() . "', condicion_uso= '" . $equipoReq->getCondicion_uso() .
                    "', num_economico= " . $equipoReq->getNum_economico() . ", num_serie= '" . $equipoReq->getNum_serie() .
                    "', id_laboratorio= " . $equipoReq->getId_laboratorio() .
                    " WHERE id = " . $equipoReq->getId() . ";";
            }
            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Equipo actualizado con exito!!!";
                $datos['resultOper'] = 1;

                if ($equipoReq->getImagen()) { //si viene una imagen se renombra la imagen
                    $resultSave = ClassControllerFiles::subirArchivoAlServidor($imagen_anterior, $_FILES['upl'], $nombre_imagen, "equipos");
                    // $datos['mensaje'] .=  $resultSave['mensaje']; //descomentar en caso de que no se suban las imagenes
                }
            } else {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Ups... No fue posible actualizar la informacion.";
                $datos['resultOper'] = 2;
            }
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }


        return $datos;
    }
    public static function getEquipos($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {

            $sql = "SELECT id, nombre, condicion_uso, num_economico, num_serie, id_laboratorio, imagen,eliminado,fecha_baja
             FROM equipo WHERE eliminado = 0;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Equipo = new Equipo;

                $Equipo->setId($row->id);
                $Equipo->setNombre($row->nombre);
                $Equipo->setCondicion_uso($row->condicion_uso);
                $Equipo->setNum_economico($row->num_economico);
                $Equipo->setNum_serie($row->num_serie);
                $Equipo->setId_laboratorio($row->id_laboratorio);
                $Equipo->setImagen($row->imagen);
                $Equipo->setEliminado($row->eliminado);
                $Equipo->setFecha_baja($row->fecha_baja);

                array_push($datos['respuesta'], $Equipo); //se agrega cada registro a la variable de respuesta
                $Equipo = null;
            }

            if (count($datos['respuesta']) > 0) { //se valida que aya registros en la tabla
                $datos['mensaje'] = count($datos['respuesta']) . " registros obtenidos con exito.";
                $datos['resultOper'] = 1;
            } else {
                $datos['mensaje'] = "sin informacion para mostrar.";
                $datos['resultOper'] = 2;
            }
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
    public static function getEquipos_eliminados($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {

            $sql = "SELECT id, nombre, condicion_uso, num_economico, num_serie, id_laboratorio, eliminado
             FROM equipo WHERE eliminado = 1;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Equipo = new Equipo;

                $Equipo->setId($row->id);
                $Equipo->setNombre($row->nombre);
                $Equipo->setCondicion_uso($row->condicion_uso);
                $Equipo->setNum_economico($row->num_economico);
                $Equipo->setNum_serie($row->num_serie);
                $Equipo->setId_laboratorio($row->id_laboratorio);
                $Equipo->setEliminado($row->eliminado);

                array_push($datos['respuesta'], $Equipo); //se agrega cada registro a la variable de respuesta
                $Equipo = null;
            }

            if (count($datos['respuesta']) > 0) { //se valida que aya registros en la tabla
                $datos['mensaje'] = count($datos['respuesta']) . " registros obtenidos con exito.";
                $datos['resultOper'] = 1;
            } else {
                $datos['mensaje'] = "sin informacion para mostrar.";
                $datos['resultOper'] = 2;
            }
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
    public static function insert_mantenimiento($conexMySql, $mantenimientoReq)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {

            $sql = "INSERT INTO mantenimiento(fecha_mantenimiento, observaciones, id_equipo)
                VALUES ('" . $mantenimientoReq->getFecha_mantenimiento() . "','" . $mantenimientoReq->getObservaciones() . "'," .
                $mantenimientoReq->getId_equipo() . ");";

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Mantenimiento registrado con exito!!! ";
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
    public static function update_mantenimiento($conexMySql, $mantenimientoReq)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {

            $sql = "UPDATE mantenimiento SET fecha_mantenimiento= '" . $mantenimientoReq->getFecha_mantenimiento() .
                "', observaciones= '" . $mantenimientoReq->getObservaciones() .
                "' WHERE id = " . $mantenimientoReq->getId() . ";";

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Mantenimiento actualizado con exito!!!";
                $datos['resultOper'] = 1;
            } else {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Ups... No fue posible actualizar la informacion.";
                $datos['resultOper'] = 2;
            }
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }


        return $datos;
    }
    //obtiene los mantenimientos del id del equipo que se le pase por parametro
    public static function getMantenimientos($conexMySql, $id_equipo)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {
            $sql = "SELECT id, fecha_mantenimiento, observaciones, id_equipo, eliminado
            FROM mantenimiento WHERE id_equipo = $id_equipo AND eliminado = 0;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Mantenimiento = new Mantenimiento;

                $Mantenimiento->setId($row->id);
                $Mantenimiento->setFecha_mantenimiento($row->fecha_mantenimiento);
                $Mantenimiento->setObservaciones($row->observaciones);
                $Mantenimiento->setId_equipo($row->id_equipo);
                $Mantenimiento->setEliminado($row->eliminado);

                array_push($datos['respuesta'], $Mantenimiento); //se agrega cada registro a la variable de respuesta
                $Mantenimiento = null; //se libera de memoria
            }

            if (count($datos['respuesta']) > 0) { //se valida que aya registros en la tabla
                $datos['mensaje'] = count($datos['respuesta']) . " registros obtenidos con exito.";
                $datos['resultOper'] = 1;
            } else {
                $datos['mensaje'] = "sin informacion para mostrar.";
                $datos['resultOper'] = 2;
            }
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
    public static function getLaboratorios($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {

            $sql = "SELECT id, nombre, admin, descripcion FROM laboratorio;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($datos['respuesta'], $row); //se agrega cada registro a la variable de respuesta
            }

            if (count($datos['respuesta']) > 0) { //se valida que aya registros en la tabla
                $datos['mensaje'] = count($datos['respuesta']) . " registros obtenidos con exito.";
                $datos['resultOper'] = 1;
            } else {
                $datos['mensaje'] = "sin informacion para mostrar.";
                $datos['resultOper'] = 2;
            }
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
    public static function delete($conexMySql, $id_equipo)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {
            $sql = "UPDATE equipo SET eliminado= 1, fecha_baja = NOW() WHERE id = " . $id_equipo . ";";

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Equipo eliminado con exito!!!";
                $datos['resultOper'] = 1;
            } else {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Ups... No fue posible Eliminar la informacion.";
                $datos['resultOper'] = 2;
            }
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
    public static function delete_mantenimiento($conexMySql, $id_mantenimiento)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {
            $sql = "UPDATE mantenimiento SET eliminado= 1 WHERE id = " . $id_mantenimiento . ";";

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Mantenimiento eliminado con exito!!!";
                $datos['resultOper'] = 1;
            } else {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Ups... No fue posible Eliminar la informacion.";
                $datos['resultOper'] = 2;
            }
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
}
