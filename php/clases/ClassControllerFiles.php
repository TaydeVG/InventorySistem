<?php

class ClassControllerFiles
{
    public static function subirArchivoAlServidor($imagen_anterior, $archivo, $renameImagen, $carpeta)
    {
        $datos                 = array();
        $datos['mensaje']      = "";
        $datos['resultOper']   = 0;

        $allowed = array('png', 'jpg', 'gif');
        if (isset($archivo) && $archivo['error'] == 0) {
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowed)) {
                $datos['resultOper'] = -1;
                $datos['mensaje'] .= "ocurrio un problema al subir la imagen";
            }

            $carpeta = "../resources/imagenes/imagenes-upload/$carpeta/";
            //si la carpeta temporal no existe, se crea en la ruta $carpeta
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            //elimina la imagen vieja para que solo quede la nueva, solo en caso de actualizar imagen
            if ($imagen_anterior != null) {
                $rutaIMG_toDelet = $carpeta . "/" . $imagen_anterior;
                ClassControllerFiles::eliminarImagen($rutaIMG_toDelet); //elimino la imagen si ya existe
            }

            if (move_uploaded_file($_FILES['upl']['tmp_name'], $carpeta . $renameImagen)) {
                $datos['resultOper'] = 1;
                $datos['mensaje'] .= "imagen Subida con exito ";
            }
        } else {
            $datos['resultOper']   = 0;
            $datos['mensaje'] .= "bad request";
        }
        return $datos;
    }
    public static function eliminarImagen($ruta)
    {
        $datos                 = array();
        $datos['mensaje']      = null;
        $datos['resultOper']   = 0;
        $datos['infoResponse'] = array();
        if ($ruta != "") {
            if (ClassControllerFiles::validaExistImagen($ruta)) // elimina el archivo solo si existe
            {
                try {

                    if (unlink($ruta)) {
                        $datos['mensaje'] = "Imagen Eliminada!";
                        $datos['resultOper'] = 1;
                    } else {
                        $datos['mensaje'] = "No es posible eliminar la imagen";
                        $datos['resultOper'] = 2;
                    }
                } catch (Exception $e) {
                    $datos['mensaje']    = $e;
                    $datos['resultOper'] = -1;
                }
            } else {
                $datos['mensaje'] = "Imagen no encontrada!";
                $datos['resultOper'] = 3;
            }
        } else {
            $datos['mensaje'] = "Datos vacios!";
            $datos['resultOper'] = 4;
        }
        return $datos;
    }
    public static function validaExistImagen($rutaImagen)
    {
        $result = false;

        $arrayRuta = explode('/', $rutaImagen);
        $tamañoArray = count($arrayRuta);
        $nombreArchivo = $arrayRuta[$tamañoArray - 1];

        if ($nombreArchivo != "" && $nombreArchivo != null) { // valida que en la ruta se especifique el nombre del archivo
            if (file_exists($rutaImagen)) {
                $result = true;
            }
        }
        return $result;
    }
}
