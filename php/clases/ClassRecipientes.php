<?php
require_once("../php/objetos/Recipiente.object.php");
require_once("../php/objetos/tipo_material.object.php");

class ClassRecipientes
{
    public static function insert($conexMySql, $recipienteReq)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {
            $nombre_imagen = null;
            if ($recipienteReq->getImagen()) { //si viene una imagen se renombra la imagen
                $nombre_original = $recipienteReq->getImagen()['name'];
                $estructura = explode(".", $nombre_original);
                $extencion = $estructura[count($estructura) - 1];
                $nombre_imagen = getdate()['0'] . "." . $extencion;

                $sql = "INSERT INTO recipiente(nombre, id_tipo_material, capacidad, id_laboratorio, imagen)
                    VALUES ('" . $recipienteReq->getNombre() . "'," . $recipienteReq->getId_tipo_material() . ",'" .
                    $recipienteReq->getCapacidad() . "'," . $recipienteReq->getId_laboratorio() .
                    ",'$nombre_imagen');";
            } else {
                $sql = "INSERT INTO recipiente(nombre, id_tipo_material, capacidad, id_laboratorio)
                VALUES ('" . $recipienteReq->getNombre() . "'," . $recipienteReq->getId_tipo_material() . ",'" .
                    $recipienteReq->getCapacidad() . "'," . $recipienteReq->getId_laboratorio() . ");";
            }

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Recipiente registrado con exito!!! ";
                $datos['resultOper'] = 1;

                if ($recipienteReq->getImagen()) { //si viene entra al if
                    $resultSave = ClassControllerFiles::subirArchivoAlServidor(null, $_FILES['upl'], $nombre_imagen, "recipientes");
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
    public static function getRecipientes($conexMySql)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {
            $sql = "SELECT rec.id, rec.nombre, rec.id_tipo_material, rec.capacidad, rec.id_laboratorio,rec.imagen, rec.eliminado,rec.fecha_baja,tm.tipo_material
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
                $Recipiente->setImagen($row->imagen);
                $Recipiente->setEliminado($row->eliminado);
                $Recipiente->setFecha_baja($row->fecha_baja);

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
    public static function update($conexMySql, $recipienteReq, $imagen_anterior)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {
            $nombre_imagen = null;
            if ($recipienteReq->getImagen()) { //si viene una imagen se renombra la imagen
                $nombre_original = $recipienteReq->getImagen()['name'];
                $estructura = explode(".", $nombre_original);
                $extencion = $estructura[count($estructura) - 1];
                $nombre_imagen = getdate()['0'] . "." . $extencion;
                $sql = "UPDATE recipiente SET nombre= '" . $recipienteReq->getNombre() . "', id_tipo_material= " . $recipienteReq->getId_tipo_material() .
                    ", capacidad= '" . $recipienteReq->getCapacidad() . "', id_laboratorio= " . $recipienteReq->getId_laboratorio() .
                    ", imagen= '" . $nombre_imagen . "' WHERE id = " . $recipienteReq->getId() . ";";
            } else {
                $sql = "UPDATE recipiente SET nombre= '" . $recipienteReq->getNombre() . "', id_tipo_material= " . $recipienteReq->getId_tipo_material() .
                    ", capacidad= '" . $recipienteReq->getCapacidad() . "', id_laboratorio= " . $recipienteReq->getId_laboratorio() .
                    " WHERE id = " . $recipienteReq->getId() . ";";
            }
            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Recipiente actualizado con exito!!!";
                $datos['resultOper'] = 1;

                if ($recipienteReq->getImagen()) { //si viene una imagen se renombra la imagen
                    $resultSave = ClassControllerFiles::subirArchivoAlServidor($imagen_anterior, $_FILES['upl'], $nombre_imagen, "recipientes");
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
    public static function delete($conexMySql, $id_recipiente)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {
            $sql = "UPDATE recipiente SET eliminado= 1, fecha_baja = NOW() WHERE id = " . $id_recipiente . ";";

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "Recipiente eliminado con exito!!!";
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
