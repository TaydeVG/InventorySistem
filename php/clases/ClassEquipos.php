<?php
require_once("../php/objetos/Equipos.object.php");

class ClassEquipos
{
    public static function getEquipos($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {

            $sql = "SELECT id, nombre, condicion_uso, num_economico, num_serie, id_laboratorio, eliminado
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
}
