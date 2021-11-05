<?php

/**
 * 
 */
class Recipiente
{
    public $id = 0;
    public $nombre = "";
    public $tipo_material = 0;
    public $capacidad = "";
    public $id_laboratorio = 0;
    public $fecha_alta = "";

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

    public function getTipo_material()
    {
        return $this->tipo_material;
    }
    public function setTipo_material($tipo_material)
    {
        $this->tipo_material = $tipo_material;
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

    public function getFecha_alta()
    {
        return $this->fecha_alta;
    }
    public function setFecha_alta($fecha_alta)
    {
        $this->fecha_alta = $fecha_alta;
    }

}
