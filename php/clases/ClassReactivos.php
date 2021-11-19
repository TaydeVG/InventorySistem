<?php
require_once("../php/objetos/Reactivos.object.php");

class ClassReactivos
{

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
}
