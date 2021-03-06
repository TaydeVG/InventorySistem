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
            //si no viene un id tipo material, se pasara a registrar uno
            if (!$recipienteReq->getId_tipo_material()) {
                $valida_tipo_material = ClassRecipientes::valida_tipo_material($conexMySql, $recipienteReq->getNombre_tipo_material());
                //si es igual a 1, se asigna el id del tipo material registrado
                if ($valida_tipo_material['resultOper'] == 1) {
                    $tipo_material = $valida_tipo_material['respuesta'];
                    $recipienteReq->setId_tipo_material($tipo_material->id);
                } else { //si entra al else es porque hubo un problema en la validacion del tipo material y retorna el problema
                    $datos['mensaje']    = $valida_tipo_material['mensaje'];
                    $datos['resultOper'] = -2;
                    return $datos;
                }
            }

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
            //si no viene un id tipo material, se pasara a registrar uno
            if (!$recipienteReq->getId_tipo_material()) {
                $valida_tipo_material = ClassRecipientes::valida_tipo_material($conexMySql, $recipienteReq->getNombre_tipo_material());
                //si es igual a 1, se asigna el id del tipo material registrado
                if ($valida_tipo_material['resultOper'] == 1) {
                    $tipo_material = $valida_tipo_material['respuesta'];
                    $recipienteReq->setId_tipo_material($tipo_material->id);
                } else { //si entra al else es porque hubo un problema en la validacion del tipo material y retorna el problema
                    $datos['mensaje']    = $valida_tipo_material['mensaje'];
                    $datos['resultOper'] = -2;
                    return $datos;
                }
            }

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
            $sql = "SELECT rec.id, rec.nombre, rec.id_tipo_material, rec.capacidad, rec.id_laboratorio, rec.eliminado,tm.tipo_material,rec.fecha_baja
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
    //valida si el tipo material es uno nuevo, lo registra y retorna su id
    public static function valida_tipo_material($conexMySql, $req_tipo_material)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {

            $tipo_material_resp = ClassRecipientes::getTipo_material($conexMySql, $req_tipo_material);

            //si retorna 1, quiere decir que ya existia ese tipo material, por lo que se retorna el id
            if ($tipo_material_resp['resultOper'] == 1) {
                $datos['respuesta'] = $tipo_material_resp['respuesta'];
                $datos['mensaje'] = "El tipo material ya existe";
                $datos['resultOper'] = 1;
            } else { //si es diferente de 1, se pasara a registrar el nuevo material y se retornara su id
                $resp_guardado = ClassRecipientes::insert_tipo_material($conexMySql, $req_tipo_material);
                //si es igual a 1 quiere decir que se registro correctamente el tipo material y retorna su id
                if ($resp_guardado['resultOper'] == 1) {
                    $new_tipo_material_resp = ClassRecipientes::getTipo_material($conexMySql, $req_tipo_material);
                    $datos['respuesta'] = $new_tipo_material_resp['respuesta'];
                    $datos['mensaje'] = $new_tipo_material_resp['mensaje'];
                    $datos['resultOper'] = 1;
                } else {
                    $datos['mensaje'] = $resp_guardado['mensaje'];
                    $datos['resultOper'] = $resp_guardado['resultOper'];
                }
            }
        } catch (Exception $e) {
            $datos['mensaje'] = $e;
            $datos['resultOper'] = -1;
        }
        return $datos;
    }
    public static function insert_tipo_material($conexMySql, $tipo_material)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;
        $sql = "";
        try {

            $sql = "INSERT INTO tipo_material(tipo_material)
                VALUES ('" . $tipo_material . "');";

            $consulta = $conexMySql->prepare($sql);

            $isSave = $consulta->execute();
            if ($isSave) {
                $datos['respuesta'] = $isSave;
                $datos['mensaje'] = "material registrado con exito!!! ";
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
    public static function getTipo_material($conexMySql, $tipo_material)
    {
        $datos               = array();
        $datos['mensaje']    = "";
        $datos['respuesta']  = array();
        $datos['resultOper'] = 0;

        try {
            $sql = "SELECT id, tipo_material FROM tipo_material WHERE tipo_material = '$tipo_material' limit 1;";
            $consulta = $conexMySql->prepare($sql);
            $consulta->execute();

            while ($row = $consulta->fetch(PDO::FETCH_OBJ)) {
                $Tipo_Material = new Tipo_Material;

                $Tipo_Material->setId($row->id);
                $Tipo_Material->setTipo_material($row->tipo_material);

                $datos['respuesta'] = $Tipo_Material; //se agrega cada registro a la variable de respuesta
                $Tipo_Material = null; //se libera de memoria
            }

            if ($datos['respuesta']) { //se valida que aya registros en la tabla
                $datos['mensaje'] = "Registro obtenido con exito.";
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
