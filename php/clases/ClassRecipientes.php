<?php
require_once("../php/objetos/Recipiente.object.php");

class ClassRecipientes
{
    public static function getRecipientes($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {
            $Recipiente = new Recipiente;

            $Recipiente->setId(1);
            $Recipiente->setNombre("basija 1");
            $Recipiente->setTipo_material(1);
            $Recipiente->setCapacidad("Gramos");
            $Recipiente->setId_laboratorio(1);
            $Recipiente->setFecha_alta("27-10-2021");

            array_push($datos['respuesta'], $Recipiente);
            $Recipiente = new Recipiente;
            $Recipiente->setId(2);
            $Recipiente->setNombre("basija 2");
            $Recipiente->setTipo_material(1);
            $Recipiente->setCapacidad("Gramos");
            $Recipiente->setId_laboratorio(1);
            $Recipiente->setFecha_alta("20-10-2021");
            array_push($datos['respuesta'], $Recipiente);
            array_push($datos['respuesta'], $Recipiente);
            array_push($datos['respuesta'], $Recipiente);
            array_push($datos['respuesta'], $Recipiente);
            array_push($datos['respuesta'], $Recipiente);
            array_push($datos['respuesta'], $Recipiente);

            $datos['mensaje'] = "informacion obtenida con exito.";
            $datos['resultOper'] = 1;
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
}
