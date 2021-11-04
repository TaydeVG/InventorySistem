<?php

/**
 * 
 */
class Reactivo
{
    public $id = 0;
    public $nombre = "";
    public $reactividad = "";
    public $unidad_medida = "";
    public $caducidad = "";
    public $inflamabilida = "";
    public $riesgo_salud = "";
    public $presentacion = "";
    public $codigo_almacenamiento = "";
    public $n_reactivo = "";
    public $n_mueble = "";
    public $n_estante = "";
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

    public function getReactividad()
    {
        return $this->reactividad;
    }
    public function setReactividad($reactividad)
    {
        $this->reactividad = $reactividad;
    }

    public function getUnidad_medida()
    {
        return $this->unidad_medida;
    }
    public function setUnidad_medida($unidad_medida)
    {
        $this->unidad_medida = $unidad_medida;
    }

    public function getCaducidad()
    {
        return $this->caducidad;
    }
    public function setCaducidad($caducidad)
    {
        $this->caducidad = $caducidad;
    }

    public function getInflamabilida()
    {
        return $this->inflamabilida;
    }
    public function setInflamabilida($inflamabilida)
    {
        $this->inflamabilida = $inflamabilida;
    }

    public function getRiesgo_salud()
    {
        return $this->riesgo_salud;
    }
    public function setRiesgo_salud($riesgo_salud)
    {
        $this->riesgo_salud = $riesgo_salud;
    }

    public function getPresentacion()
    {
        return $this->presentacion;
    }
    public function setPresentacion($presentacion)
    {
        $this->presentacion = $presentacion;
    }

    public function getCodigo_almacenamiento()
    {
        return $this->codigo_almacenamiento;
    }
    public function setCodigo_almacenamiento($codigo_almacenamiento)
    {
        $this->codigo_almacenamiento = $codigo_almacenamiento;
    }

    public function getN_reactivo()
    {
        return $this->n_reactivo;
    }
    public function setN_reactivo($n_reactivo)
    {
        $this->n_reactivo = $n_reactivo;
    }

    public function getN_mueble()
    {
        return $this->n_mueble;
    }
    public function setN_mueble($n_mueble)
    {
        $this->n_mueble = $n_mueble;
    }

    public function getN_estante()
    {
        return $this->n_estante;
    }
    public function setN_estante($n_estante)
    {
        $this->n_estante = $n_estante;
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
