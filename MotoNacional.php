<?php 

class MotoNacional extends Moto{
    private $porcentajeDescuento;

    public function __construct($codigo, $costo, $año_fabricacion, $descripcion, $porcentajeIncAnual, $activa, $porcentajeDescuento)
    {
        parent :: __construct($codigo, $costo, $año_fabricacion, $descripcion, $porcentajeIncAnual, $activa);
        $this->porcentajeDescuento = $porcentajeDescuento;
    }

    public function getDescuento(){
        return $this->porcentajeDescuento;
    }
    public function setDescuento ($porcentajeDescuento){
        $this->porcentajeDescuento = $porcentajeDescuento;
    }

    public function __toString()
    {
        $mostrar = parent::__toString();
        $mostrar = $mostrar . "\nDescuento: ". $this->getDescuento(). "\n";
        return $mostrar;
    }

    public function darPrecioVenta()
    {
        $precio = parent::darPrecioVenta();
        $descuento = $this->getDescuento();

        $precioDescuento = $precio * ($descuento /100);
        $precioFinal = $precio - $precioDescuento;
        return $precioFinal;
    }
}