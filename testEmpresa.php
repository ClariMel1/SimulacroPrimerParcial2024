<?php
include_once 'Cliente.php';
include_once 'Moto.php';
include_once 'Venta.php';
include_once 'Empresa.php';

//1. Cree 2 instancias de la clase Cliente: $objCliente1, $objCliente2
$objCliente1 = new Cliente("Ameli", "Venegas", true, "DNI", 45978889);
$objCliente2 = new Cliente("Ivan", "Lopez", true, "DNI", 92926837);
$coleccionClientes = [$objCliente1, $objCliente2];

//2. Cree 3 objetos Motos con la información visualizada en la tabla:
$objMoto1 = new Moto(11, 2230000, 2022, "Benelli Imperiale 400", 85, true);
$objMoto2 = new Moto(12,584000, 2021, "Zanella Zr 150 Ohc", 70, true );
$objMoto3 = new Moto(13, 999900, 2023, "Zanella Patagonia Eagle 250", 55, false);
$coleccionMotos = [$objMoto1, $objMoto2, $objMoto3];

$coleccionVentas = [];

//4. Se crea un objeto Empresa con la siguiente información:
$objEmpresa = new Empresa("Alta Gama", "Av Argentina 123", $coleccionClientes, $coleccionMotos, $coleccionVentas);

do{
    echo "**************************************". "\n";
    echo "(1) Registrar una Venta.". "\n";
    echo "(2) Registrar un cliente.". "\n";
    echo "(3) Ventas por Cliente.". "\n";
    echo "(4) Buscar informacion sobre una Moto ". "\n";
    echo "(5) Agregar Moto a la venta". "\n";
    echo "(6) Mostrar Informacion cargada". "\n";
    echo "(7) Salir". "\n";
    echo "**************************************". "\n";
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case '1':
            echo "Cliente que realice la compra:". "\n";
            echo "Tipo de Documento:";
            $tipo = trim(fgets(STDIN));
            echo "Numero de Documento:";
            $numero = trim(fgets(STDIN));
            
            $cliente = $objEmpresa->checkClienteRegistrado($tipo, $numero);
            $codigosMoto= $objEmpresa->arregloCodigos();
            $importe = $objEmpresa->registrarVenta($codigosMoto, $cliente);
            echo "El precio del importe total es de ". $importe . "\n";
            break;
        case '2':
            echo "Nombre:";
            $nombre = trim(fgets(STDIN));
            echo "Apellido:";
            $apellido = trim(fgets(STDIN));
            echo "Esta dado de baja?(s/n):";
            $baja = trim(fgets(STDIN));
            if($baja == "si"){
                echo "(!!!)No puede registrar compras desde el momento de su baja.". "\n";
            }else{
                $baja = true;
                echo "Tipo de Documento:";
                $tipo = trim(fgets(STDIN));
                echo "Numero de Documento:";
                $numero = trim(fgets(STDIN));
                $objEmpresa->registrarCliente($nombre, $apellido, $baja, $tipo, $numero);
            }
            break;
        case '3':
            echo "Tipo de Documento:";
            $tipo = trim(fgets(STDIN));
            echo "Numero de Documento:";
            $numero = trim(fgets(STDIN));
            $ventaCliente= $objEmpresa->retornarVentasXCliente($tipo, $numero);
            if($ventaCliente == null){
                echo "El cliente dado no ha realizado ninguna compra porque no figura en la lista.". "\n";
            }else{
                echo $ventaCliente . "\n";
            }
            break;
        case '4':
            echo "Para buscar info, ingresar Codigo del mismo:";
            $codigo = trim(fgets(STDIN));
            $mostrar= $objEmpresa->retornarMoto($codigo);
            if($mostrar == false){
                echo "(!!!) El codigo ingresado NO figura en la lista de motos a la venta.". "\n";
            }else{
                echo $mostrar . "\n";
            }
            break;
        case '5':
            echo "Codigo:". "\n";
            $codigo = trim(fgets(STDIN));
            echo "Costo:". "\n";
            $costo = trim(fgets(STDIN));
            echo "Año de Fabricacion:". "\n";
            $año = trim(fgets(STDIN));
            echo "Descripcion:". "\n";
            $descripcion = trim(fgets(STDIN));
            echo "Porcentaje de Incremento Anual:". "\n";
            $porcentaje = trim(fgets(STDIN));
            echo "Disponible a la venta?(s/n):". "\n";
            $activa = trim(fgets(STDIN));
            if($activa == "s"){
                $activa = true;
            }else{
                $activa = false;
            }
             $objEmpresa->agregarMoto($codigo, $costo, $año, $descripcion, $porcentaje, $activa);
            break;
        case '6':
            echo $objEmpresa->__toString(). "\n";
            break;
    }
}while($opcion !=7);

?>
