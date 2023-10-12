<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
// $proveedor = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
// $id_item = (isset($_POST['id_item'])) ? $_POST['id_item'] : '';
// $concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';

// $importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';
$descuento = (isset($_POST['descuento'])) ? $_POST['descuento'] : '';
$gtotal = (isset($_POST['gtotal'])) ? $_POST['gtotal'] : '';
//$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res = 0;


switch ($opcion) {
    case 1: //alta
        $consulta = "UPDATE cxptmp set fecha='$fecha',id_prov='$id_prov',descripcion='$descripcion',
        subtotal='$subtotal',iva='$iva',total='$total',descuento='$descuento',gtotal='$gtotal', activo='1' WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

  
            //TERMINA EL INCREMENTO EN INVENTARIO   



        break;
    case 2:


        break;

    case 3:
        $consulta = "UPDATE cxp SET estado_cxp='0' WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        // CONSULTA DEL DETALLE
        $consulta = "SELECT * FROM detallecxp_herramienta WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {

            // EMPIEZA EL INCREMENTO EN INVENTARIO
            $id = $row['id_her'];
            $tipomov = 'Salida Can';
            $saldo = 0;
            $montomov = $row['cant_her'];
            $saldofin = 0;
            $descripcion = "CANCELACION DE COMPRA DE HERRAMIENTA CXP FOLIO: ". $folio;
            
            $usuario=$row['usuario'];
            
         
            $consultam = "SELECT * from herramienta where id_her='$id'";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $datam = $resultadom->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datam as $rowdatam) {
                    $saldo = $rowdatam['cant_her'];
                }
                $res += 1;
            }

            $saldofin = $saldo - $montomov;

            //guardar el movimiento
            $consultam = "INSERT INTO mov_herramienta(id_her,fecha_movh,tipo_movh,cantidad,saldoini,saldofin,descripcion,usuario) values('$id','$fecha_actual','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario')";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $res += 1;
            }

            $consultam = "UPDATE herramienta SET cant_her='$saldofin' WHERE id_her='$id'";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $res += 1;
            }
            //TERMINA EL INCREMENTO EN INVENTARIO   

        }


        
        break;
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
