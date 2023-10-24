<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';

$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';
$descuento = (isset($_POST['descuento'])) ? $_POST['descuento'] : '';
$gtotal = (isset($_POST['gtotal'])) ? $_POST['gtotal'] : '';
//$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';

$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res = 0;


switch ($opcion) {
    case 1: //alta
        $consulta = "UPDATE cxptmp set fecha='$fecha',id_prov='$id_prov',descripcion='$descripcion',
        subtotal='$subtotal',iva='$iva',total='$total',descuento='$descuento',gtotal='$gtotal',
        saldo='$gtotal',tipo='$tipo',usuario='$usuario',
        total='$total',activo='1' WHERE folio_cxp='$folio'";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        $consulta2 = "INSERT INTO cxp (fecha,id_prov,descripcion,subtotal,iva,total,descuento,gtotal,saldo,tipo,folio_tmp,usuario) 
        values ('$fecha','$id_prov','$descripcion','$subtotal','$iva','$total','$descuento','$gtotal','$gtotal','$tipo','$folio','$usuario')";
        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();

        $consulta3 = "SELECT * FROM cxp WHERE folio_tmp='$folio'";
        $resultado3 = $conexion->prepare($consulta3);
        $resultado3->execute();
        $data = $resultado3->fetchAll(PDO::FETCH_ASSOC);
        $folion = "";
        foreach ($data as $row) {
            $folion = $row['folio_cxp'];
        }


        $consulta4 = "SELECT * from cxp_detalletmp where folio_cxp='$folio' order by id_reg";
        $resultado4 = $conexion->prepare($consulta4);
        $resultado4->execute();
        $data2 = $resultado4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data2 as $row) {
            $id_item = $row['id_item'];
            $cantidad = $row['cantidad'];
            $costo = $row['costo'];
            $importe = $row['importe'];
            $descuento2 = $row['descuento'];
            $gimporte = $row['gimporte'];


            $consulta5 = "INSERT INTO cxp_detalle (folio_cxp,id_item,cantidad,costo,importe,descuento,gimporte)
            values ('$folion','$id_item','$cantidad','$costo','$importe','$descuento2','$gimporte')";
            $resultado5 = $conexion->prepare($consulta5);
            $resultado5->execute();
        }





        break;
    case 2:

        $consulta = "UPDATE cxptmp set fecha='$fecha',id_prov='$id_prov',descripcion='$descripcion',
        subtotal='$subtotal',iva='$iva',total='$total',descuento='$descuento',gtotal='$gtotal',
        saldo='$gtotal',tipo='$tipo',usuario='$usuario',
        activo='1' WHERE folio_cxp='$folio'";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        $consulta2 = "UPDATE cxp set fecha='$fecha',id_prov='$id_prov',descripcion='$descripcion',
        subtotal='$subtotal',iva='$iva',total='$total',descuento='$descuento',gtotal='$gtotal',
        saldo='$gtotal',tipo='$tipo',usuario='$usuario'
        WHERE folio_tmp='$folio'";

        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();

        $consulta3 = "SELECT * FROM cxp WHERE folio_tmp='$folio'";
        $resultado3 = $conexion->prepare($consulta3);
        $resultado3->execute();
        $data = $resultado3->fetchAll(PDO::FETCH_ASSOC);
        $folion = "";
        foreach ($data as $row) {
            $folion = $row['folio_cxp'];
        }


        $consultad = "DELETE FROM cxp_detalle where folio_cxp='$folion'";
        $resultadod = $conexion->prepare($consultad);
        $resultadod->execute();

        $consulta4 = "SELECT * from cxp_detalletmp where folio_cxp='$folio' order by id_reg";
        $resultado4 = $conexion->prepare($consulta4);
        $resultado4->execute();
        $data2 = $resultado4->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data2 as $row) {
            $id_item = $row['id_item'];
            $cantidad = $row['cantidad'];
            $costo = $row['costo'];
            $importe = $row['importe'];
            $descuento2 = $row['descuento'];
            $gimporte = $row['gimporte'];

            $consulta5 = "INSERT INTO cxp_detalle (folio_cxp,id_item,cantidad,costo,importe,descuento,gimporte)
            values ('$folion','$id_item','$cantidad','$costo','$importe','$descuento2','$gimporte')";
            $resultado5 = $conexion->prepare($consulta5);
            $resultado5->execute();
        }

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
            $descripcion = "CANCELACION DE COMPRA DE HERRAMIENTA CXP FOLIO: " . $folio;

            $usuario = $row['usuario'];


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
