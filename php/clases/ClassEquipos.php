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
            $Equipo = new Equipo;

            $Equipo->setId(1);
            $Equipo->setNombre("Tubo pbc");
            $Equipo->setCondicion_uso("ahi anda");
            $Equipo->setMantenimiento(1);
            $Equipo->setNum_economico(3432);
            $Equipo->setNum_serie("2009324");
            $Equipo->setId_laboratorio(2);
            $Equipo->setFecha_alta("27-10-2021");

            array_push($datos['respuesta'], $Equipo);
            $Equipo = new Equipo;
            $Equipo->setId(2);
            $Equipo->setNombre("Balvula ilidio");
            $Equipo->setCondicion_uso("ahi anda");
            $Equipo->setMantenimiento(1);
            $Equipo->setNum_economico(3432);
            $Equipo->setNum_serie("2009324");
            $Equipo->setId_laboratorio(2);
            $Equipo->setFecha_alta("20-10-2021");
            array_push($datos['respuesta'], $Equipo);
            array_push($datos['respuesta'], $Equipo);
            array_push($datos['respuesta'], $Equipo);
            array_push($datos['respuesta'], $Equipo);
            array_push($datos['respuesta'], $Equipo);
            array_push($datos['respuesta'], $Equipo);
            array_push($datos['respuesta'], $Equipo);
            array_push($datos['respuesta'], $Equipo);
            array_push($datos['respuesta'], $Equipo);
            array_push($datos['respuesta'], $Equipo);
            array_push($datos['respuesta'], $Equipo);

            $datos['mensaje'] = "informacion obtenida con exito.";
            $datos['resultOper'] = 1;
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
}