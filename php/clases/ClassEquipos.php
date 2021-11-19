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
        $Equipo = new Equipo;

        try {

            $sql = "SELECT id, nombre, condicion_uso, num_economico, num_serie, id_laboratorio, eliminado
             FROM equipo;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Equipo->setId($row->id);
                $Equipo->setNombre($row->nombre);
                $Equipo->setCondicion_uso($row->condicion_uso);
                $Equipo->setNum_economico($row->num_economico);
                $Equipo->setNum_serie($row->num_serie);
                $Equipo->setId_laboratorio($row->id_laboratorio);
                $Equipo->setEliminado($row->eliminado);

                array_push($datos['respuesta'], $Equipo); //se agrega cada registro a la variable de respuesta
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
        $Reactivo = null; //se libera de memoria
        return $datos;
    }
    public static function getMantenimientos($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {
            $Mantenimiento = new Mantenimiento;

            $Mantenimiento->setId(1);
            $Mantenimiento->setFecha_mantenimiento("2020-10-10");
            $Mantenimiento->setObservaciones("Se realizo mantenimiento preventivo");

            array_push($datos['respuesta'], $Mantenimiento);
            $Mantenimiento = new Mantenimiento;
            $Mantenimiento->setId(2);
            $Mantenimiento->setFecha_mantenimiento("2020-09-10");
            $Mantenimiento->setObservaciones("Se realizo mantenimiento correctivo");

            array_push($datos['respuesta'], $Mantenimiento);
            array_push($datos['respuesta'], $Mantenimiento);
            array_push($datos['respuesta'], $Mantenimiento);
            array_push($datos['respuesta'], $Mantenimiento);
            array_push($datos['respuesta'], $Mantenimiento);
            array_push($datos['respuesta'], $Mantenimiento);
            array_push($datos['respuesta'], $Mantenimiento);
            array_push($datos['respuesta'], $Mantenimiento);
            array_push($datos['respuesta'], $Mantenimiento);
            array_push($datos['respuesta'], $Mantenimiento);
            array_push($datos['respuesta'], $Mantenimiento);

            $datos['mensaje'] = "informacion obtenida con exito.";
            $datos['resultOper'] = 1;
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
}
