<?php

/**
 * Se registra la siguiente información: código, costo, año fabricación, descripción, porcentaje
 * incremento anual, activa (atributo que va a contener un valor true, si la moto está disponible para la
 * venta y false en caso contrario).
*/

class Moto {
    private $codigo;
    private $costo;
    private $año_fabricacion;
    private $descripcion;
    private $porcentajeIncAnual;
    private $activa;

    //2. Método constructor que recibe como parámetros cada uno de los valores a ser asignados a cada atributo de la clase.
    public function __construct($codigo, $costo, $año_fabricacion, $descripcion, $porcentajeIncAnual, $activa)
    {
        $this->codigo = $codigo;
        $this->costo = $costo;
        $this->año_fabricacion = $año_fabricacion;
        $this->descripcion = $descripcion;
        $this->porcentajeIncAnual = $porcentajeIncAnual;
        $this->activa = $activa;
    }

    //3. Los métodos de acceso de cada uno de los atributos de la clase.
    public function getCodigo(){
        return $this->codigo;
    }
    public function setCodigo($codigo){
        $this->codigo = $codigo;
    }

    public function getCosto(){
        return $this->costo;
    }
    public function setCosto($costo){
        $this->costo = $costo;
    }

    public function getAñoFabricacion(){
        return $this->año_fabricacion;
    }
    public function setAñoFabricacion($año_fabricacion){
        $this->año_fabricacion = $año_fabricacion;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    public function getPorcentaje(){
        return $this->porcentajeIncAnual;
    }
    public function setPorcentaje($porcentajeIncAnual){
        $this->porcentajeIncAnual = $porcentajeIncAnual;
    }

    public function getActiva(){
        return $this->activa;
    }
    public function setActiva($activa){
        $this->activa = $activa;
    }


    //4. Redefinir el método _toString para que retorne la información de los atributos de la clase.
    public function __toString()
    {
        return "Codigo: ". $this->getCodigo(). "\n" . 
               "Costo: ". $this->darPrecioVenta(). "\n" . 
               "Año de Fabricacion: ". $this->getAñoFabricacion() . "\n". 
               "Descripcion: ". $this->getDescripcion(). "\n". 
               "Porcentaje de Incremento Anual: ". $this->getPorcentaje(). "%     ". "Activa: ". $this->checkEstadoMoto(). "\n";
    }

    // 5. Implementar el método darPrecioVenta el cual calcula el valor por el cual puede ser vendida una moto
    public function darPrecioVenta(){
        $costo = $this->getCosto();
        $anio = 2024- $this->getAñoFabricacion(); // Obtener el año actual
        $porcentajeIncrementoAnual = $this->getPorcentaje();
        $disponibilidad = $this->getActiva();

        if ($disponibilidad) { 
            $precioVenta = $costo + ($costo * ($anio * ($porcentajeIncrementoAnual / 100)));
        } else {
            $precioVenta = -1;
        }   

        return $precioVenta;
    }

    public function checkEstadoMoto(){
        $bandera = $this->getActiva();
        if($bandera == true){
            $mostrar = 1;
        }else{
            $mostrar = 0;
        }
        return $mostrar;
    }
}

?>