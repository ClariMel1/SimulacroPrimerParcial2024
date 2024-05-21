<?php

/**
 * Se registra la siguiente información: denominación, dirección, la colección de clientes, colección de
 * motos y la colección de ventas realizadas.
*/

class Empresa{
    private $denominacion;
    private $direccion;
    private $arregloClientes;
    private $arregloMotos;
    private $ventasRealizadas;

    //2. Método constructor que recibe como parámetros los valores iniciales para los atributos de la clase.
    public function __construct($denominacion, $direccion, $arregloClientes, $arregloMotos, $ventasRealizadas)
    {
        $this->denominacion = $denominacion;
        $this->direccion = $direccion;
        $this->arregloClientes = $arregloClientes;
        $this->arregloMotos = $arregloMotos;
        $this->ventasRealizadas = $ventasRealizadas;
    }

    //3. Los métodos de acceso para cada una de las variables instancias de la clase.
    public function getDenominacion(){
        return $this->denominacion;
    }
    public function setDenominacion($denominacion){
        $this->denominacion = $denominacion;
    }

    public function getDirrecion(){
        return $this->direccion;
    }
    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }

    public function getClientes(){
        return $this->arregloClientes;
    }
    public function setClientes($arregloClientes){
        $this->arregloClientes = $arregloClientes;
    }

    public function getMotos(){
        return $this->arregloMotos;
    }
    public function setMotos($arregloMotos){
        $this->arregloMotos = $arregloMotos;
    }

    public function getVentas(){
        return $this->ventasRealizadas;
    }
    public function setVentas($ventasRealizadas){
        $this->ventasRealizadas = $ventasRealizadas;
    }

    public function mostrarClientes(){
        $mostrar = "";
        $clientes = $this->getClientes();
        for ($i = 0; $i < count($clientes); $i++) {
            $mostrar = $mostrar. $clientes[$i] . "\n";
        }
        return $mostrar;  
    }
    public function mostrarMotos(){
        $mostrar= "";
        $motos = $this->getMotos();
        for ($i = 0; $i < count($motos); $i++) {
            $mostrar = $mostrar. $motos[$i]. "\n";
        }
        return $mostrar;
    }

    public function mostrarVentas(){
        $mostrar = "";
        $ventas = $this->getVentas();
        for ($i = 0; $i < count($ventas); $i++) {
            $venta = $ventas[$i]->__toString();
            $mostrar = $mostrar .  $venta;
        }

        return $mostrar;
    }

    //4. Redefinir el método _toString para que retorne la información de los atributos de la clase.
    public function __toString()
    {
        return "Empresa: ". $this->getDenominacion(). "\n". 
               "Direccion: ". $this->getDirrecion(). "\n". 
               "\nColeccion de Clientes: " . "\n". 
               $this->mostrarClientes(). "\n". 
               "Coleccion de Motos: ". "\n". 
               $this->mostrarMotos(). "\n". 
               "Coleccion de Ventas: ". "\n". 
               $this->mostrarVentas(). "\n";
    }

    //5. Implementar el método retornarMoto($codigoMoto) que recorre la colección de motos de la Empresa y
    //retorna la referencia al objeto moto cuyo código coincide con el recibido por parámetro.
    public function retornarMoto($codigoMoto){
        $motos = $this->getMotos();
        $bandera = false;

        $i=0;
        while($i< count($motos) && $bandera == false){
            if($motos[$i]->getCodigo() == $codigoMoto){
                $bandera = $motos[$i];
            }else{
                $bandera = false;
                $i++;
            }
        }

        return $bandera;
    }

    /**
     * 6. Implementar el método registrarVenta($colCodigosMoto, $objCliente) método que recibe por
     * parámetro una colección de códigos de motos, la cual es recorrida, y por cada elemento de la colección
     * se busca el objeto moto correspondiente al código y se incorpora a la colección de motos de la instancia
     * Venta que debe ser creada. Recordar que no todos los clientes ni todas las motos, están disponibles
     * para registrar una venta en un momento determinado.
     * El método debe setear los variables instancias de venta que corresponda y retornar el importe final de la
     * venta.
    */


    public function registrarVenta($colCodigosMoto, $objCliente){
        $checkVenta = count($this->getVentas());
        $nroVenta = $checkVenta + 1;
        $fecha = date('l j f');
        $importeFinal = 0;
        $arregloMotos = [];
        $objVenta = new Venta($nroVenta, $fecha, $objCliente, $arregloMotos, $importeFinal);

        for ($i = 0; $i< count($colCodigosMoto); $i++){
            $codigo = $colCodigosMoto[$i];
            $moto = $this->retornarMoto($codigo);
            if($moto != false && $moto->getActiva() == 1 && $objCliente->getEstado() == 1){
                $arregloMotos[]= $moto;
                $importe = $objVenta->incorporarMoto($moto);
                $importeFinal = $importeFinal + $importe;
                $objVenta->setPrecioFinal($importeFinal);
            }
        }

        if($importeFinal !=0){
            array_push($this->ventasRealizadas, $objVenta);
        }else{
            $importeFinal = null;
        }

        return $importeFinal;
    }

    public function checkClienteRegistrado($tipo, $numDoc){
        $clientes = $this->arregloClientes;
        $registrado = false;
        $i=0;
        while($i< count($clientes) && $registrado == false){
            $cliente = $clientes[$i];
            if($cliente->getTipoDoc() == $tipo && $cliente->getNroDoc() == $numDoc){
                $registrado = $cliente;
            }
            $i++;
        }
        return $registrado;
    }

    //7. Implementar el método retornarVentasXCliente($tipo,$numDoc) que recibe por parámetro el tipo y
    // número de documento de un Cliente y retorna una colección con las ventas realizadas al cliente.
    public function retornarVentasXCliente($tipo, $numDoc){
        $ventaXcliente = "";
        $ventas = $this->getVentas();
        $clienteEncontrado = false;
    
        for ($i = 0; $i < count($ventas); $i++) {
            $venta = $ventas[$i];
            $cliente = $venta->getCliente();
            if($cliente->getTipoDoc() == $tipo && $cliente->getNroDoc() == $numDoc){
                $clienteEncontrado = true;
                $venta = $ventas[$i]->__toString();
                $ventaXcliente = $ventaXcliente .  $venta; 
            }
        }

        if($clienteEncontrado == false){
            $ventaXcliente = null;
        }

        return $ventaXcliente;
    }

    /**
     * Implementar el método informarSumaVentasNacionales() que recorre la colección de ventas realizadas por la empresa y retorna el importe total de ventas Nacionales realizadas por la empresa.
     */
    public function informarSumaVentaNacionales(){
        $ventas = $this->ventasRealizadas;
        $importeTotal = 0;

        for($i=0; $i<count($ventas); $i++){
            $venta = $ventas[$i];
            if($venta){
                $importe_por_venta = $venta->retornarTotalVentaNacional();
                $importeTotal = $importeTotal + $importe_por_venta;
            }
        }
        return $importeTotal;
    }

    /**
     * Implementar el método informarVentasImportadas() que recorre la colección de ventas realizadas por la empresa y retorna una colección de ventas de motos  importadas. Si en la venta al menos una de las motos es importada la venta debe ser informada.
     */
    public function informarVentasImportadas(){
        $ventas = $this->ventasRealizadas;
        $ventasImportadas = [];

        for($i=0; $i<count($ventas); $i++){
            $venta = $ventas[$i];
            if($venta){
                $arreglo_por_venta = $venta->retornarMotosImportadas();
                array_push($ventasImportadas, $arreglo_por_venta);
            }
        }
        return $ventasImportadas;
    }
}
?>