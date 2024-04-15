<?php

/**
 * Se registra la siguiente información: nombre, apellido, si está o no dado de baja, el tipo y el número de
 * documento. Si un cliente está dado de baja, no puede registrar compras desde el momento de su baja.
*/

class Cliente{
    private $nombre;
    private $apellido;
    private $estado_baja;
    private $tipoDocumento;
    private $nroDocumento;

    // 1. Método constructor que recibe como parámetros los valores iniciales para los atributos.
    public function __construct($nombre, $apellido, $estado_baja, $tipoDocumento, $nroDocumento)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->estado_baja = $estado_baja;
        $this->tipoDocumento = $tipoDocumento;
        $this->nroDocumento = $nroDocumento;
    }

    //2. Los métodos de acceso de cada uno de los atributos de la clase.
    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getApellido(){
        return $this->apellido;
    } 
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    public function getEstado(){
        return $this->estado_baja;
    }
    public function setEstado($estado_baja){
        $this->estado_baja = $estado_baja;
    }

    public function getTipoDoc(){
        return $this->tipoDocumento;
    }
    public function setTipoDoc($tipoDocumento){
        $this->tipoDocumento = $tipoDocumento;
    }

    public function getNroDoc(){
        return $this->nroDocumento;
    }
    public function setNroDoc($nroDocumento){
        $this->nroDocumento = $nroDocumento;
    }

    //3. Redefinir el método _toString para que retorne la información de los atributos de la clase.
    public function __toString()
    {
        return "Cliente: ". $this->getNombre() . " ". $this->getApellido(). "\n" . 
                "Documento: ". $this->getTipoDoc(). " - ". $this->getNroDoc() . "\n". 
                "Estado: " . $this->getEstado(). "\n";
    }

    public function checkEstadoBaja(){
        $bandera = $this->getEstado();
        if($bandera == true){
            $mostrar = 1;
        }else{
            $mostrar = -1;
        }
        return $mostrar;
    }
}

?>