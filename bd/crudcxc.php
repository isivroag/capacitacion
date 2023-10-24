<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$id_cliente = (isset($_POST['id_cliente'])) ? $_POST['id_cliente'] : '';
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
$tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res = 0;


switch ($opcion) {
    case 1: //alta
        $consulta = "UPDATE cxctmp set fecha='$fecha',id_cliente='$id_cliente',descripcion='$descripcion',
        subtotal='$subtotal',iva='$iva',total='$total',descuento='$descuento',gtotal='$gtotal',
        saldo='$gtotal',tipo='$tipo',usuario='$usuario',
        activo='1' WHERE folio_cxc='$folio'";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        /*$consultad = "SELECT * from cxptmp where folio_cxp='$folio'";

        $resultadod = $conexion->prepare($consultad);
        $resultadod->execute();

        $datad = $resultadod->fetchAll(PDO::FETCH_ASSOC);

        foreach ($datad as $dt) {

            $folio =  $dt['folio_cxp'];
            $fecha = $dt['fecha'];
            $id_prov = $dt['id_prov'];
            $descripcion = $dt['descripcion'];
            $subtotal =  $dt['subtotal'];
            $iva =  $dt['iva'];
            $total =  $dt['total'];
            $descuento =  $dt['descuento'];
            $gtotal =  $dt['gtotal'];
            $saldo =  $dt['saldo'];
            $tipo =  $dt['tipo'];
        }*/

        //$fecha = date('Y-m-d');
        $consultag = "INSERT INTO cxc (fecha,id_cliente,descripcion,subtotal,iva,total,descuento,gtotal,saldo,tipo,usuario,folio_tmp) 
                    values ('$fecha','$id_cliente','$descripcion','$subtotal','$iva','$total','$descuento','$gtotal','$gtotal','$tipo','$usuario','$folio')";

        $resultadog = $conexion->prepare($consultag);
        $resultadog->execute();

        $consultan = "SELECT * FROM cxc WHERE folio_tmp= '$folio'";
        $resultadon = $conexion->prepare($consultan);
        $resultadon->execute();
        $data = $resultadon->fetchAll(PDO::FETCH_ASSOC);
        $folion="";

        foreach ($data as $row) {

            $folion =  $row['folio_cxc'];
        
        }

        $consultadet = "SELECT * from cxc_detalletmp where folio_cxc='$folio' order by id_reg";

        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();
        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);

        foreach ($datadet as $dt) {

            $id_item = $dt['id_item'];
            $cantidad = $dt['cantidad'];
            $precio =  $dt['precio'];
            $importe =  $dt['importe'];
            $descuento2 =  $dt['descuento'];
            $gimporte =  $dt['gimporte'];
        

        $consultadd = "INSERT INTO cxc_detalle (folio_cxc,id_item,cantidad,precio,importe,descuento,gimporte) 
        values('$folion','$id_item','$cantidad','$precio','$importe','$descuento2','$gimporte')";
        $resultadodd = $conexion->prepare($consultadd);
        $resultadodd->execute();

    }


        break;
    case 2:

        $consulta = "UPDATE cxctmp set fecha='$fecha',id_cliente='$id_cliente',descripcion='$descripcion',
        subtotal='$subtotal',iva='$iva',total='$total',descuento='$descuento',gtotal='$gtotal',
        saldo='$gtotal',tipo='$tipo',usuario='$usuario',
        activo='1' WHERE folio_cxc='$folio'";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        $consultag = "UPDATE cxc set fecha='$fecha',id_cliente='$id_cliente',descripcion='$descripcion',
        subtotal='$subtotal',iva='$iva',total='$total',descuento='$descuento',gtotal='$gtotal',
        saldo='$gtotal',tipo='$tipo',usuario='$usuario'
        WHERE folio_tmp='$folio'";

        $resultadog = $conexion->prepare($consultag);
        $resultadog->execute();

        $consultan = "SELECT * FROM cxc WHERE folio_tmp= '$folio'";
        $resultadon = $conexion->prepare($consultan);
        $resultadon->execute();
        $data = $resultadon->fetchAll(PDO::FETCH_ASSOC);
        $folion="";

        foreach ($data as $row) {

            $folion =  $row['folio_cxc'];
        
        }

        $consultabr = "DELETE * from cxc_detalle where folio_cxc='$folion'";
        $resultadobr = $conexion->prepare($consultabr);
        $resultadobr->execute();
                
        $consultadet = "SELECT * from cxc_detalletmp where folio_cxc='$folio' order by id_reg";
        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();
        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);

        foreach ($datadet as $dt) {

            $id_item = $dt['id_item'];
            $cantidad = $dt['cantidad'];
            $precio =  $dt['precio'];
            $importe =  $dt['importe'];
            $descuento2 =  $dt['descuento'];
            $gimporte =  $dt['gimporte'];
        

        $consultadd = "INSERT INTO cxc_detalle (folio_cxc,id_item,cantidad,precio,importe,descuento,gimporte) 
        values('$folion','$id_item','$cantidad','$precio','$importe','$descuento2','$gimporte')";
        $resultadodd = $conexion->prepare($consultadd);
        $resultadodd->execute();

        }

        break;

    case 3:
        $consulta = "UPDATE cxc SET estado_cxc='0' WHERE folio_cxc='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        // CONSULTA DEL DETALLE
        $consulta = "SELECT * FROM detallecxc_herramienta WHERE folio_cxc='$folio'";
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
