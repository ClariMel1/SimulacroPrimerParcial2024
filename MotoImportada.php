<?php

class MotoImportada extends Moto{
    private $paisOrigen;
    private $impuestos;

    public function __construct($codigo, $costo, $año_fabricacion, $descripcion, $porcentajeIncAnual, $activa, $paisOrigen, $impuestos)
    {
        parent :: __construct($codigo, $costo, $año_fabricacion, $descripcion, $porcentajeIncAnual, $activa);
        $this->paisOrigen = $paisOrigen;
        $this->impuestos = $impuestos;
    }

    public function getPaisOrigen (){
        return $this->paisOrigen;
    }
    public function setPaisOrigen($paisOrigen){
        $this->paisOrigen = $paisOrigen;
    }

    public function getImpuestos (){
        return $this->impuestos;
    }

    public function setImpuestos($impuestos){
        $this->impuestos = $impuestos;
    }

    public function __toString()
    {
        $mostrar = parent::__toString();
        $mostrar = $mostrar . "Pais de Origen: ". $this->getPaisOrigen(). "\nImpuesots: ". $this->getImpuestos(). "\n";
        return $mostrar;
    }

    public function darPrecioVenta()
    {
        $precio = parent::darPrecioVenta();
        $impuesto = $this->getImpuestos();

        $precioFinal = $precio + $impuesto;
        return $precioFinal;
    }

}