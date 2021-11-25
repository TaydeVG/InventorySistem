<?php

/**
 * 
 */
class Equipo
{
    public $id = 0;
    public $nombre = "";
    public $condicion_uso = "";
    public $num_economico = 0;
    public $num_serie = "";
    public $id_laboratorio = 0;
    public $eliminado = false;
    public $fecha_baja = "";
    public $imagen = "";

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

    public function getEliminado()
    {
        return $this->eliminado;
    }
    public function setEliminado($eliminado)
    {
        $this->eliminado = $eliminado;
    }

    public function getFecha_baja()
    {
        return $this->fecha_baja;
    }
    public function setFecha_baja($fecha_baja)
    {
        $this->fecha_baja = $fecha_baja;
    }

    public function getImagen()
    {
        return $this->imagen;
    }
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
}

/**
 * 
 */
class Mantenimiento
{
    public $id = 0;
    public $fecha_mantenimiento = "";
    public $observaciones = "";
    public $id_equipo = 0;
    public $eliminado = false;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFecha_mantenimiento()
    {
        return $this->fecha_mantenimiento;
    }
    public function setFecha_mantenimiento($fecha_mantenimiento)
    {
        $this->fecha_mantenimiento = $fecha_mantenimiento;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }
    public function getId_equipo()
    {
        return $this->id_equipo;
    }
    public function setId_equipo($id_equipo)
    {
        $this->id_equipo = $id_equipo;
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
