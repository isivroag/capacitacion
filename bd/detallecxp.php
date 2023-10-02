<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$iditem= (isset($_POST['iditem'])) ? $_POST['iditem'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';
$descuento = (isset($_POST['descuento'])) ? $_POST['descuento'] : '';
$gimporte = (isset($_POST['gimporte'])) ? $_POST['gimporte'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO cxp_detalle (folio_cxp,id_item,cantidad,precio,importe,descuento,gimporte) 
                    values ('$folio','$iditem','$cantidad','$precio','$importe','$descuento','$gimporte')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from cxp_detalle where folio_cxp='$folio'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $total=0;
        foreach ($data as $row) {
            $total+=$row['importe'];
        }

        $consulta = "UPDATE cxp set total='$total' where folio_cxp='$folio'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from detalle_cxp where folio_cxp='$folio' and id_item='$iditem'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


        break;
        case 2:
            $consulta = "DELETE FROM detalle_cxp where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
            $consulta = "SELECT * from detalle_cxp where folio_cxp='$folio'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $total=0;
            foreach ($data as $row) {
                $total+=$row['ímporte'];
            }
    
            $consulta = "UPDATE cxp set total='$total' where folio_cxp='$folio'";
            
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data=1;
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>