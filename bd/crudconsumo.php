<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$fecha_salida = (isset($_POST['fecha_salida'])) ? $_POST['fecha_salida'] : '';
$responsable = (isset($_POST['responsable'])) ? $_POST['responsable'] : '';
$evento = (isset($_POST['evento'])) ? $_POST['evento'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$res = 0;
$fecha=date('Y-m-d');



switch ($opcion) {
    case 1: //alta
        $consulta = "UPDATE consumo set fecha='$fecha',fecha_salida='$fecha_salida',responsable='$responsable',
        evento='$evento',obs='$obs', usuario='$usuario',activo='1' WHERE folio_cons='$folio'";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        $consultan = "SELECT * FROM consumo_det WHERE folio_cons= '$folio' ";
        $resultadon = $conexion->prepare($consultan);
        $resultadon->execute();
        $data = $resultadon->fetchAll(PDO::FETCH_ASSOC);


        foreach ($data as $row) {





            $id_ins =  $row['id_ins'];
            $cantidad =  $row['cantidad'];


            $consulta2 = "SELECT * FROM insumo WHERE id_ins= '$id_ins' ";
            $resultado2 = $conexion->prepare($consulta2);
            $resultado2->execute();
            $data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);
            $saldoini = 0;
            $saldofin = 0;
            foreach ($data2 as $row2) {
                $saldoini = $row2['cantidad'];
            }

            $saldofin = $saldoini - $cantidad;
            $tipo = 'Salida';
            $descripcion = "Salida por consumo folio # " . $folio;
          

            $consultam = "INSERT INTO insumo_mov(id_ins,fecha,tipo,cantidad,saldoini,saldofin,descripcion,usuario) 
                values('$id_ins','$fecha','$tipo','$cantidad','$saldoini','$saldofin','$descripcion','$usuario')";
            $resultadom = $conexion->prepare($consultam);
            $resultadom->execute();



            $consulta = "UPDATE insumo SET cantidad =  '$saldofin' WHERE id_ins = '$id_ins' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        }






        break;
    case 2:
        /*
        $consulta = "UPDATE consumo set fecha='$fecha',fecha_salida='$fecha_salida',responsable='$responsable',
        evento='$evento',obs='$obs', usuario='$usuario',
        activo='1' WHERE folio_cons='$folio'";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;
//MODIFICAR NO DESCUENTA DE INVETARIO, EVITAR MODIFICAR
        $consultan = "SELECT * FROM consumo_det WHERE folio_cons= '$folio' ";
        $resultadon = $conexion->prepare($consultan);
        $resultadon->execute();
        $data = $resultadon->fetchAll(PDO::FETCH_ASSOC);


        foreach ($data as $row) {

            $id_ins =  $row['id_ins'];
            $cantidad =  $row['cantidad'];

            $consulta = "UPDATE insumo SET cantidad = cantidad - '$cantidad' WHERE id_ins = '$id_ins' ";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
        }
*/
        break;

    case 3:
        $consulta = "UPDATE consumo SET estado='CANCELADO' WHERE folio_cons='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        $consulta = "SELECT * FROM consumo_det WHERE folio_cons='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {

            $id = $row['id_ins'];
            $cantidad = $row['cantidad'];

            $consulta2 = "SELECT * FROM insumo WHERE id_ins= '$id' ";
            $resultado2 = $conexion->prepare($consulta2);
            $resultado2->execute();
            $data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);
            $saldoini = 0;
            $saldofin = 0;
            foreach ($data2 as $row2) {
                $saldoini = $row2['cantidad'];
            }

            $saldofin = $saldoini + $cantidad;
            $tipo = 'Entrada';
            $descripcion = "Entrada por cancelación consumo folio # " . $folio;
          

            $consultam = "INSERT INTO insumo_mov(id_ins,fecha,tipo,cantidad,saldoini,saldofin,descripcion,usuario) 
                values('$id','$fecha','$tipo','$cantidad','$saldoini','$saldofin','$descripcion','$usuario')";
            $resultadom = $conexion->prepare($consultam);
            $resultadom->execute();

            $consultam = "UPDATE insumo set cantidad = '$saldofin' WHERE id_ins='$id'";
            $resultadom = $conexion->prepare($consultam);
            $resultadom->execute();
        }

        break;
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
