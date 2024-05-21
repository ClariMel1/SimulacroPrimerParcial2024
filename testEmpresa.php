<?php
include_once 'Cliente.php';
include_once 'Moto.php';
include_once 'Venta.php';
include_once 'Empresa.php';

//1. Cree 2 instancias de la clase Cliente: $objCliente1, $objCliente2
$objCliente1 = new Cliente("Ameli", "Venegas", true, "DNI", 45978889);
$objCliente2 = new Cliente("Ivan", "Lopez", true, "DNI", 92926837);
$coleccionClientes = [$objCliente1, $objCliente2];

//2. Cree 4 objetos Motos con la información visualizada en la tabla:
$objMoto1 = new MotoNacional(11, 2230000, 2022, "Benelli Imperiale 400", 85, true, 10);
$objMoto2 = new MotoNacional(12,584000, 2021, "Zanella Zr 150 Ohc", 70, true, 10);
$objMoto3 = new MotoNacional(13, 999900, 2023, "Zanella Patagonia Eagle 250", 55, false, 10);
$objMoto4 = new MotoImportada(14, 12499900,2020, "Pitbike Enduro Motocross Apollo Aiii 190cc Plr", 100, true, "Francia", 6244400);
$coleccionMotos = [$objMoto1, $objMoto2, $objMoto3. $objMoto4];

$coleccionVentas = [];

//4. Se crea un objeto Empresa con la siguiente información:
$objEmpresa = new Empresa("Alta Gama", "Av Argentina 123", $coleccionClientes, $coleccionMotos, $coleccionVentas);

do{
    echo "**************************************". "\n";
    echo "(1) Registrar una Venta.". "\n";
    echo "(2) Ventas por Cliente.". "\n";
    echo "(3) Buscar informacion sobre una Moto ". "\n";
    echo "(4) Agregar Moto a la venta". "\n";
    echo "(5) Mostrar Informacion cargada". "\n";
    echo "(6) Salir". "\n";
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
            if($cliente==false){
                echo "Nombre:";
                $nombre = trim(fgets(STDIN));
                echo "Apellido:";
                $apellido = trim(fgets(STDIN));
                echo "Esta dado de baja?(s/n):";
                $baja = trim(fgets(STDIN));
                if($baja == "s"){
                    echo "(!!!)No puede registrar compras desde el momento de su baja.". "\n";
                }elseif($baja == "n"){
                    $estado = true;
                    $cliente = new Cliente($nombre, $apellido, $estado, $tipo, $numero);
                    array_push($coleccionClientes, $cliente);
                    echo "Cliente registrado! :)". "\n";
                }else{
                    echo "Error (x)". "\n";
                }
            }
            print_r($coleccionMotos);
            $codigosMoto=[];
            do{
                echo "Ingrese el codigo de moto a comprar:(x para terminar)";
                $codigo=trim(fgets(STDIN));
                array_push($codigosMoto,$codigo);
            }while($codigo!="x");
            $importe = $objEmpresa->registrarVenta($codigosMoto, $cliente);
            echo "El precio del importe total es de ". $importe . "\n";
            break;
        case '2':
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
        case '3':
            echo "Para buscar info, ingresar Codigo del mismo:";
            $codigo = trim(fgets(STDIN));
            $mostrar= $objEmpresa->retornarMoto($codigo);
            if($mostrar == false){
                echo "(!!!) El codigo ingresado NO figura en la lista de motos a la venta.". "\n";
            }else{
                echo $mostrar . "\n";
            }
            break;
        case '4':
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
            echo "******TIPO******". "\n";
            echo "1.Moto Importada.". "\n";
            echo "2.Moto Nacional.". "\n";
            echo "****************";
            $tipo =trim(fgets(STDIN));
            if($tipo == 1){
                echo "Pais de Origen:"."\n";
                $pais=trim(fgets(STDIN));
                echo "Impuestos:". "\n";
                $impuestos=trim(fgets(STDIN));
                $motoAgregada = new MotoImportada($codigo, $costo, $año, $descripcion, $porcentaje, $activa, $pais, $impuestos);
                array_push($coleccionMotos, $motoAgregada);
            }elseif($tipo==2){
                $porcentajeDescuento = 10;
                $motoAgregada = new MotoNacional($codigo, $costo, $año, $descripcion, $porcentaje, $activa,$porcentajeDescuento);
                array_push($coleccionMotos, $motoAgregada);
            }else{
                echo "Error (x)!!!". "\n";
            }
            echo "Moto Agregada!:)". "\n";
            break;
        case '5':
            echo "************MOSTRAR*************"."\n";
            echo "1.Ver Todas las Ventas Importadas". "\n";
            echo "2.Ver Suma de ventas Nacionales". "\n";
            echo "3.Ver resumen de Empresa.". "\n";
            echo "*********************************". "\n";
            $mostrar = trim(fgets(STDIN));
            if($mostrar == 1){
                $ventasImportadas = $objEmpresa->informarVentasImportadas();
                print_r($ventasImportadas);
            }elseif($mostrar ==2){
                echo $objEmpresa->informarSumaVentaNacionales();
            }else{
                echo $objEmpresa->__toString(). "\n";
            }
            break;
    }
}while($opcion !=6);

?>
