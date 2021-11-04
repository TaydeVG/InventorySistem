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
            $Reactivo = new Reactivo;

            $Reactivo->setId(1);
            $Reactivo->setNombre("Azul de anilino 1");
            $Reactivo->setReactividad(1);
            $Reactivo->setUnidad_medida("Gramos");
            $Reactivo->setCaducidad("2025-01-01");
            $Reactivo->setInflamabilida(1);
            $Reactivo->setRiesgo_salud(2);
            $Reactivo->setPresentacion("");
            $Reactivo->setCodigo_almacenamiento(0);
            $Reactivo->setN_reactivo("");
            $Reactivo->setN_mueble(1);
            $Reactivo->setN_estante(1);
            $Reactivo->setFecha_alta("27-10-2021");

            array_push($datos['respuesta'], $Reactivo);
            $Reactivo = new Reactivo;
            $Reactivo->setId(2);
            $Reactivo->setNombre("Azul de anilino 2");
            $Reactivo->setReactividad(1);
            $Reactivo->setUnidad_medida("Gramos");
            $Reactivo->setCaducidad("No se observa");
            $Reactivo->setInflamabilida(1);
            $Reactivo->setRiesgo_salud(2);
            $Reactivo->setPresentacion("");
            $Reactivo->setCodigo_almacenamiento(0);
            $Reactivo->setN_reactivo("");
            $Reactivo->setN_mueble(1);
            $Reactivo->setN_estante(1);
            $Reactivo->setFecha_alta("20-10-2021");
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);
            array_push($datos['respuesta'], $Reactivo);

            $datos['mensaje'] = "informacion obtenida con exito.";
            $datos['resultOper'] = 1;
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
}
