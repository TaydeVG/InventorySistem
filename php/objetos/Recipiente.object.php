<?php

/**
 * 
 */
class Recipiente
{
    public $id = 0;
    public $nombre = "";
    public $id_tipo_material = 0;
    public $nombre_tipo_material = 0;
    public $capacidad = "";
    public $id_laboratorio = 0;
    public $eliminado = "";

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getId_tipo_material()
    {
        return $this->id_tipo_material;
    }
    public function setId_tipo_material($id_tipo_material)
    {
        $this->id_tipo_material = $id_tipo_material;
    }
    public function getNombre_tipo_material()
    {
        return $this->nombre_tipo_material;
    }
    public function setNombre_tipo_material($nombre_tipo_material)
    {
        $this->nombre_tipo_material = $nombre_tipo_material;
    }

    public function getCapacidad()
    {
        return $this->capacidad;
    }
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;
    }

    public function getId_laboratorio()
    {
        return $this->id_laboratorio;
    }
    public function setId_laboratorio($id_laboratorio)
    {
        $this->id_laboratorio = $id_laboratorio;
    }

    public function getEliminado()
    {
        return $this->eliminado;
    }
    public function setEliminado($eliminado)
    {
        $this->eliminado = $eliminado;
    }

}
