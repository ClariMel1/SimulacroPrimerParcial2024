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
            $mostrar = $mostrar. $ventas[$i] . "\n";
        }
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
     * @return int
    */


    public function registrarVenta($colCodigosMoto, $objCliente){
        $venta = new Venta(0, 0, $objCliente, 0, 0);
        $importeFinal = 0;

        for ($i = 0; $i< count($colCodigosMoto); $i++){
            $codigo = $colCodigosMoto[$i];
            $moto = $this->retornarMoto($codigo);
            if($moto != false && $moto->getActiva() == 1 && $objCliente->getEstado() == "si"){
                $importe = $venta->incorporarMoto($moto);
                $importeFinal = $importeFinal + $importe;
            }
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

    public function arregloCodigos(){
        $arregloCodigos = [];
        $motos = $this->arregloMotos;

        for ($i = 0; $i<count($motos);$i++){
            $moto = $motos[$i];
            $codigoMoto= $moto->getCodigo();
            $arregloCodigos[] =$codigoMoto;
        }
        return $arregloCodigos;
    }

    //7. Implementar el método retornarVentasXCliente($tipo,$numDoc) que recibe por parámetro el tipo y
    // número de documento de un Cliente y retorna una colección con las ventas realizadas al cliente.
    public function retornarVentasXCliente($tipo, $numDoc){
        $ventas = $this->getVentas();
        $compra_del_cliente = [];

        $encontrarCliente = false;
        $i=0;
        while($i<count($ventas)&& $encontrarCliente == false){
            $venta = $ventas [$i];
            $cliente = $venta->getCliente();
            if($cliente->getTipoDoc() == $tipo && $cliente->getNroDoc() == $numDoc){
                $compra_del_cliente [] = $cliente; 
            }
        }

        return $compra_del_cliente;
    }

    public function registrarCliente($nombre, $apellido, $estado_baja, $tipoDocumento, $nroDocumento){
        $objCliente = new Cliente($nombre, $apellido, $estado_baja, $tipoDocumento, $nroDocumento);
        return array_push($this->arregloClientes, $objCliente);
    }

    public function agregarVenta($numero, $fecha, $objCliente, $precioFinal){
        $objVenta = new Venta ($numero, $fecha, $objCliente, $precioFinal);
        return array_push($this->ventasRealizadas, $objVenta);
    }

    public function agregarMoto($codigo, $costo, $año_fabricacion, $descripcion, $porcentajeIncAnual, $activa){
        $objMoto = new Moto($codigo, $costo, $año_fabricacion, $descripcion, $porcentajeIncAnual, $activa);
        return array_push($this->arregloMotos, $objMoto);
    }
}
?>