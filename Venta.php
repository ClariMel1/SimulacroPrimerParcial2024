<?php

/**
 * Se registra la siguiente información: número, fecha, referencia al cliente, referencia a una colección de
 * motos y el precio final.
*/

class Venta{
    private $numero;
    private $fecha;
    private $objCliente;
    private $arregloMotos;
    private $precioFinal;

    //2. Método constructor que recibe como parámetros cada uno de los valores a ser asignados a cada atributo de la clase.
    public function __construct($numero, $fecha, $objCliente,$arregloMotos,  $precioFinal)
    {
        $this->numero = $numero;
        $this->fecha = $fecha;
        $this->objCliente = $objCliente;
        $this->arregloMotos = $arregloMotos;
        $this->precioFinal = $precioFinal;
    }

    //3. Los métodos de acceso de cada uno de los atributos de la clase.
    public function getNumero(){
        return $this->numero;
    }
    public function setNumero($numero){
        $this->numero = $numero;
    }

    public function getFecha(){
        return $this->fecha;
    }
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function getCliente(){
        return $this->objCliente;
    }
    public function setCliente($objCliente){
        $this->objCliente = $objCliente;
    }

    public function getMotos(){
        return $this->arregloMotos;
    }
    public function setMotos($arregloMotos){
        $this->arregloMotos = $arregloMotos;
    }

    public function getPrecioFinal(){
        return $this->precioFinal;
    }
    public function setPrecioFinal($precioFinal){
        $this->precioFinal= $precioFinal;
    }

    public function mostrarMotos(){
        $mostrar= "";
        $motos = $this->getMotos();
        for ($i = 0; $i < count($motos); $i++) {
            $mostrar = $mostrar. $motos[$i]. "\n";
        }
        return $mostrar;
    }

    //4. Redefinir el método _toString para que retorne la información de los atributos de la clase.
    public function __toString()
    {
        return "Numero de Venta: ". $this->getNumero(). "   ". "Fecha: ". $this->getFecha() . "\n". 
               $this->getCliente() . "\n". 
               "Coleccion de Motos: ". $this->mostrarMotos(). "\n". 
               "Precio Final: ". $this->getPrecioFinal(). "\n";  
                
    }

    /**
     * 5. Implementar el método incorporarMoto($objMoto) que recibe por parámetro un objeto moto y lo
     * incorpora a la colección de motos de la venta, siempre y cuando sea posible la venta. El método cada
     * vez que incorpora una moto a la venta, debe actualizar la variable instancia precio final de la venta.
     * Utilizar el método que calcula el precio de venta de la moto donde crea necesario.
    */
    public function incorporarMoto($objMoto){
        if($objMoto->checkEstadoMoto() != -1){
            $precioMoto = $objMoto->darPrecioVenta();
            $this->arregloMotos []= $objMoto;
            return $precioMoto;
        }
    }

    /**
     * Implementar el método retornarTotalVentaNacional() que retorna  la sumatoria del precio venta de cada una de las motos Nacionales vinculadas a la venta.
    */
    public function retornarTotalVentaNacional(){
        $suma = 0;
        $motos = $this->arregloMotos;
        for($i=0; $i <count($motos); $i++){
            $moto = $motos[$i];
            $tipo = $this->checkTipoMoto($moto);
            if($tipo == 0){
                $precio = $moto->darPrecioVenta();
                $suma = $suma + $precio;
            }
        }

        return $suma;
    }

    /**
     * Implementar el método retornarMotosImportadas() que retorna una colección de motos importadas vinculadas a la venta. Si la venta solo se corresponde con motos Nacionales la colección retornada debe ser vacía.
    */
    public function retornarMotosImportadas(){
        $motos = $this->arregloMotos;
        $arregloMotosImportadas = [];

        for($i=0; $i <count($motos); $i++){
            $moto = $motos[$i];
            $tipo = $this->checkTipoMoto($moto);
            if($tipo == 1){
                array_push ($arregloMotosImportadas, $moto);
            }
        }
        return $arregloMotosImportadas;
    }

    //Chequea el tipo de moto
    public function checkTipoMoto($objMoto){
        $tipo = null;

        if($objMoto instanceof MotoImportada){
            $tipo = 1;
        }elseif($objMoto instanceof MotoNacional){
            $tipo = 0;
        }
        return $tipo;
    }
}
?>