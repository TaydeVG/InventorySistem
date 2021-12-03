<?php

/**
 * 
 */
class DataArchivoExcel
{
    public $encabezado = "";
    public $titulo_hoja = "";
    public $nombre_archivo_excel = "";
    public $tabla_base_datos = "";
    public $columnas_base_datos = array();
    public $titulosColumnas_excel = array();
    public $condicionExtraerDatos = "";

    public function getEncabezado()
    {
        return $this->encabezado;
    }
    public function setEncabezado($encabezado)
    {
        $this->encabezado = $encabezado;
    }

    public function getTitulo_hoja()
    {
        return $this->titulo_hoja;
    }
    public function setTitulo_hoja($titulo_hoja)
    {
        $this->titulo_hoja = $titulo_hoja;
    }
    public function getNombre_archivo_excel()
    {
        return $this->nombre_archivo_excel;
    }
    public function setNombre_archivo_excel($nombre_archivo_excel)
    {
        $this->nombre_archivo_excel = $nombre_archivo_excel;
    }

    public function getColumnas_base_datos()
    {
        return $this->columnas_base_datos;
    }
    public function setColumnas_base_datos($columnas_base_datos)
    {
        $this->columnas_base_datos = $columnas_base_datos;
    }

    public function getTitulosColumnas()
    {
        return $this->titulosColumnas_excel;
    }
    public function setTitulosColumnas($titulosColumnas_excel)
    {
        $this->titulosColumnas_excel = $titulosColumnas_excel;
    }

    public function getTabla_base_datos()
    {
        return $this->tabla_base_datos;
    }
    public function setTabla_base_datos($tabla_base_datos)
    {
        $this->tabla_base_datos = $tabla_base_datos;
    }
    public function getCondicionExtraerDatos()
    {
        return $this->condicionExtraerDatos;
    }
    public function setCondicionExtraerDatos($condicionExtraerDatos)
    {
        $this->condicionExtraerDatos = $condicionExtraerDatos;
    }
}
