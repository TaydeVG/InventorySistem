<?php
require_once("../php/objetos/Recipiente.object.php");
require_once("../php/objetos/tipo_material.object.php");

class ClassRecipientes
{
    public static function getRecipientes($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {
            $sql = "SELECT rec.id, rec.nombre, rec.id_tipo_material, rec.capacidad, rec.id_laboratorio, rec.eliminado,tm.tipo_material
            FROM recipiente rec, tipo_material tm
            WHERE rec.id_tipo_material = tm.id AND rec.eliminado = 0;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Recipiente = new Recipiente;

                $Recipiente->setId($row->id);
                $Recipiente->setNombre($row->nombre);
                $Recipiente->setId_tipo_material($row->id_tipo_material);
                $Recipiente->setNombre_tipo_material($row->tipo_material);
                $Recipiente->setCapacidad($row->capacidad);
                $Recipiente->setId_laboratorio($row->id_laboratorio);
                $Recipiente->setEliminado($row->eliminado);

                array_push($datos['respuesta'], $Recipiente); //se agrega cada registro a la variable de respuesta
                $Recipiente = null; //se libera de memoria
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
    public static function getRecipientes_eliminados($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {
            $sql = "SELECT rec.id, rec.nombre, rec.id_tipo_material, rec.capacidad, rec.id_laboratorio, rec.eliminado,tm.tipo_material
            FROM recipiente rec, tipo_material tm
            WHERE rec.id_tipo_material = tm.id AND rec.eliminado = 1;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Recipiente = new Recipiente;

                $Recipiente->setId($row->id);
                $Recipiente->setNombre($row->nombre);
                $Recipiente->setId_tipo_material($row->id_tipo_material);
                $Recipiente->setNombre_tipo_material($row->tipo_material);
                $Recipiente->setCapacidad($row->capacidad);
                $Recipiente->setId_laboratorio($row->id_laboratorio);
                $Recipiente->setEliminado($row->eliminado);

                array_push($datos['respuesta'], $Recipiente); //se agrega cada registro a la variable de respuesta
                $Recipiente = null; //se libera de memoria
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
    public static function getTipo_materiales($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {
            $sql = "SELECT id, tipo_material FROM tipo_material;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Tipo_Material = new Tipo_Material;

                $Tipo_Material->setId($row->id);
                $Tipo_Material->setTipo_material($row->tipo_material);

                array_push($datos['respuesta'], $Tipo_Material); //se agrega cada registro a la variable de respuesta
                $Tipo_Material = null; //se libera de memoria
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
