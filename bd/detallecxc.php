<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$iditem= (isset($_POST['iditem'])) ? $_POST['iditem'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$descuento = (isset($_POST['descuento'])) ? $_POST['descuento'] : '';
$gimporte = (isset($_POST['gimporte'])) ? $_POST['gimporte'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO cxc_detalletmp (folio_cxc,id_item,cantidad,precio,importe,descuento,gimporte) 
                    values ('$folio','$iditem','$cantidad','$precio','$importe','$descuento','$gimporte')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from cxc_detalletmp where folio_cxc='$folio'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $subtotal=0;

        foreach ($data as $row) {
            $subtotal+=$row['gimporte'];
        }

        $consulta = "UPDATE cxctmp set subtotal='$subtotal' where folio_cxc='$folio'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from vcxc_detalletmp where folio_cxc='$folio' and id_item='$iditem'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


        /*$consultad = "SELECT * from cxptmp where folio_cxp='$folio'";
        
        $resultadod = $conexion->prepare($consultad);
        $resultadod->execute();

        $datad=$resultadod->fetchAll(PDO::FETCH_ASSOC);

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
        }
    
        $fecha = date('Y-m-d');
        $consultag = "INSERT INTO cxp (fecha,id_prov,descripcion,subtotal,iva,total,descuento,gtotal,saldo,tipo) 
                    values ('$fecha','$id_prov','$descripcion','$subtotal','$iva','$total','$descuento','$gtotal','$saldo','$tipo')";
        
        $resultadog = $conexion->prepare($consultag);
        $resultadog->execute();

        $consultan = "SELECT * FROM cxp WHERE tokenid= '$tokenid' and activo='0' ORDER BY folio_cxp DESC LIMIT 1";
        $resultadon = $conexion->prepare($consultan);
        $resultadon->execute();
        $datan = $resultadon->fetchAll(PDO::FETCH_ASSOC);

        foreach ($datan as $dt) {

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
    }

    $consultadet = "SELECT * from cxp_detalletmp where folio_cxp='$folio'";
        
        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();
        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);
        $subtotal=0;
        foreach ($datadet as $row) {
            $subtotal+=$row['gimporte'];
        }

        $fecha = date('Y-m-d');
        $consultadd = "INSERT INTO cxp_detalle (folio_cxp,id_item,cantidad,costo,importe,descuento,gimporte) 
        VALUES('$folio_cxp','$id_item','$cantidad','$costo','$importe','$descuento','$gimporte')";
        $resultadodd = $conexion->prepare($consultadd);
        $resultadodd->execute();*/


        break;
        case 2:
            $consulta = "DELETE FROM cxc_detalletmp where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
            $consulta = "SELECT * from cxc_detalletmp where folio_cxc='$folio'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $subtotal=0;
            foreach ($data as $row) {
                $subtotal+=$row['gimporte'];
            }
    
            $consulta = "UPDATE cxc_detalletmp set subtotal='$subtotal' where folio_cxc='$folio'";
            
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data=1;
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
