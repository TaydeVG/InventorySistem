<?php

/**
 * 
 */
class Equipo
{
    public $id = 0;
    public $nombre = "";
    public $condicion_uso = "";
    public $mantenimiento = 0;
    public $num_economico = 0;
    public $num_serie = "";
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

    public function getCondicion_uso()
    {
        return $this->condicion_uso;
    }
    public function setCondicion_uso($condicion_uso)
    {
        $this->condicion_uso = $condicion_uso;
    }

    public function getMantenimiento()
    {
        return $this->mantenimiento;
    }
    public function setMantenimiento($mantenimiento)
    {
        $this->mantenimiento = $mantenimiento;
    }

    public function getNum_economico()
    {
        return $this->num_economico;
    }
    public function setNum_economico($num_economico)
    {
        $this->num_economico = $num_economico;
    }

    public function getNum_serie()
    {
        return $this->num_serie;
    }
    public function setNum_serie($num_serie)
    {
        $this->num_serie = $num_serie;
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
