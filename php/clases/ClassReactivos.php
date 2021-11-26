<?php
require_once("../php/objetos/Reactivos.object.php");

class ClassReactivos
{
    public static function insert($conexMySql, $reactivoReq)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {
            $sql = "INSERT INTO reactivo(nombre, reactividad, inflamabilidad, riesgo_salud,
             presentacion, cantidad_reactivo, unidad_medida, codigo_almacenamiento, caducidad,
             num_mueble, num_estante, id_laboratorio) 
                VALUES ('" . $reactivoReq->getNombre() . "'," . $reactivoReq->getReactividad() . "," .
                $reactivoReq->getInflamabilida() . "," . $reactivoReq->getRiesgo_salud() . ",'" .
                $reactivoReq->getPresentacion() . "','" . $reactivoReq->getCantidad() . "','" .
                $reactivoReq->getUnidad_medida() . "','" . $reactivoReq->getCodigo_almacenamiento() . "','" .
                $reactivoReq->getCaducidad() . "'," . $reactivoReq->getN_mueble() . "," .
                $reactivoReq->getN_estante() . "," . $reactivoReq->getId_laboratorio() . ");";

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Reactivo registrado con exito!!!";
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
    public static function update($conexMySql, $reactivoReq)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {
            $sql = "UPDATE reactivo SET nombre= '" . $reactivoReq->getNombre() . "', reactividad= " . $reactivoReq->getReactividad() .
                ", inflamabilidad= " . $reactivoReq->getInflamabilida() . ", riesgo_salud= " . $reactivoReq->getRiesgo_salud() .
                ", presentacion= '" . $reactivoReq->getPresentacion() . "', cantidad_reactivo= '" . $reactivoReq->getCantidad() .
                "', unidad_medida= '" . $reactivoReq->getUnidad_medida() . "', codigo_almacenamiento= '" . $reactivoReq->getCodigo_almacenamiento() .
                "', caducidad= '" . $reactivoReq->getCaducidad() . "',num_mueble= " . $reactivoReq->getN_mueble() .
                ", num_estante= " . $reactivoReq->getN_estante() . ", id_laboratorio =" . $reactivoReq->getId_laboratorio() .
                " WHERE id = " . $reactivoReq->getId() . ";";

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Reactivo actualizado con exito!!!";
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
    public static function delete($conexMySql, $id_reactivo)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {
            $sql = "UPDATE reactivo SET eliminado= 1, fecha_baja = NOW() WHERE id = " . $id_reactivo . ";";

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Reactivo Eliminado con exito!!!";
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
    public static function getReactivos($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {

            $sql = "SELECT id, nombre, reactividad, inflamabilidad, riesgo_salud, presentacion, cantidad_reactivo, 
            unidad_medida, codigo_almacenamiento, caducidad, num_mueble, num_estante, id_laboratorio, eliminado
             FROM reactivo WHERE eliminado = 0;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Reactivo = new Reactivo;

                $Reactivo->setId($row->id);
                $Reactivo->setNombre($row->nombre);
                $Reactivo->setReactividad($row->reactividad);
                $Reactivo->setInflamabilida($row->inflamabilidad);
                $Reactivo->setRiesgo_salud($row->riesgo_salud);
                $Reactivo->setPresentacion($row->presentacion);
                $Reactivo->setCantidad($row->cantidad_reactivo);
                $Reactivo->setUnidad_medida($row->unidad_medida);
                $Reactivo->setCodigo_almacenamiento($row->codigo_almacenamiento);
                $Reactivo->setCaducidad($row->caducidad);
                $Reactivo->setN_mueble($row->num_mueble);
                $Reactivo->setN_estante($row->num_estante);
                $Reactivo->setId_laboratorio($row->id_laboratorio);
                $Reactivo->setEliminado($row->eliminado);

                array_push($datos['respuesta'], $Reactivo); //se agrega cada registro a la variable de respuesta
                $Reactivo = null; //se libera de memoria

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
    public static function getReactivosCaducados($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {

            $sql = "SELECT id, nombre, reactividad, inflamabilidad, riesgo_salud, presentacion, cantidad_reactivo, 
            unidad_medida, codigo_almacenamiento, caducidad, num_mueble, num_estante, id_laboratorio, eliminado
             FROM reactivo WHERE caducidad < NOW() AND eliminado = 0;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Reactivo = new Reactivo;

                $Reactivo->setId($row->id);
                $Reactivo->setNombre($row->nombre);
                $Reactivo->setReactividad($row->reactividad);
                $Reactivo->setInflamabilida($row->inflamabilidad);
                $Reactivo->setRiesgo_salud($row->riesgo_salud);
                $Reactivo->setPresentacion($row->presentacion);
                $Reactivo->setCantidad($row->cantidad_reactivo);
                $Reactivo->setUnidad_medida($row->unidad_medida);
                $Reactivo->setCodigo_almacenamiento($row->codigo_almacenamiento);
                $Reactivo->setCaducidad($row->caducidad);
                $Reactivo->setN_mueble($row->num_mueble);
                $Reactivo->setN_estante($row->num_estante);
                $Reactivo->setId_laboratorio($row->id_laboratorio);
                $Reactivo->setEliminado($row->eliminado);

                array_push($datos['respuesta'], $Reactivo); //se agrega cada registro a la variable de respuesta
                $Reactivo = null; //se libera de memoria
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
    public static function getReactivosPorCaducar($conexMySql, $tiempo_que_falta)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {

            $sql = "SELECT id, nombre, reactividad, inflamabilidad, riesgo_salud, presentacion, cantidad_reactivo, 
            unidad_medida, codigo_almacenamiento, caducidad, num_mueble, num_estante, id_laboratorio, eliminado
             FROM reactivo WHERE caducidad BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL $tiempo_que_falta) AND eliminado = 0;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Reactivo = new Reactivo;

                $Reactivo->setId($row->id);
                $Reactivo->setNombre($row->nombre);
                $Reactivo->setReactividad($row->reactividad);
                $Reactivo->setInflamabilida($row->inflamabilidad);
                $Reactivo->setRiesgo_salud($row->riesgo_salud);
                $Reactivo->setPresentacion($row->presentacion);
                $Reactivo->setCantidad($row->cantidad_reactivo);
                $Reactivo->setUnidad_medida($row->unidad_medida);
                $Reactivo->setCodigo_almacenamiento($row->codigo_almacenamiento);
                $Reactivo->setCaducidad($row->caducidad);
                $Reactivo->setN_mueble($row->num_mueble);
                $Reactivo->setN_estante($row->num_estante);
                $Reactivo->setId_laboratorio($row->id_laboratorio);
                $Reactivo->setEliminado($row->eliminado);

                array_push($datos['respuesta'], $Reactivo); //se agrega cada registro a la variable de respuesta
                $Reactivo = null; //se libera de memoria
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
    public static function getReactivos_eliminados($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {

            $sql = "SELECT id, nombre, reactividad, inflamabilidad, riesgo_salud, presentacion, cantidad_reactivo, 
            unidad_medida, codigo_almacenamiento, caducidad, num_mueble, num_estante, id_laboratorio, eliminado,fecha_baja
             FROM reactivo WHERE eliminado = 1;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Reactivo = new Reactivo;

                $Reactivo->setId($row->id);
                $Reactivo->setNombre($row->nombre);
                $Reactivo->setReactividad($row->reactividad);
                $Reactivo->setInflamabilida($row->inflamabilidad);
                $Reactivo->setRiesgo_salud($row->riesgo_salud);
                $Reactivo->setPresentacion($row->presentacion);
                $Reactivo->setCantidad($row->cantidad_reactivo);
                $Reactivo->setUnidad_medida($row->unidad_medida);
                $Reactivo->setCodigo_almacenamiento($row->codigo_almacenamiento);
                $Reactivo->setCaducidad($row->caducidad);
                $Reactivo->setN_mueble($row->num_mueble);
                $Reactivo->setN_estante($row->num_estante);
                $Reactivo->setId_laboratorio($row->id_laboratorio);
                $Reactivo->setFecha_baja($row->fecha_baja);
                $Reactivo->setEliminado($row->eliminado);

                array_push($datos['respuesta'], $Reactivo); //se agrega cada registro a la variable de respuesta
                $Reactivo = null; //se libera de memoria

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
}
