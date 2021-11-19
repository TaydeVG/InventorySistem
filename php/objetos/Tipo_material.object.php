<?php

/**
 * 
 */
class Tipo_Material
{
    public $id = 0;
    public $tipo_material = "";

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTipo_material()
    {
        return $this->tipo_material;
    }
    public function setTipo_material($tipo_material)
    {
        $this->tipo_material = $tipo_material;
    }
}
