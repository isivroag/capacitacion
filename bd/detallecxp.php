<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$iditem= (isset($_POST['iditem'])) ? $_POST['iditem'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$importe = (isset($_POST['importe'])) ? $_POST['importe'] : '';
$descuento = (isset($_POST['descuento'])) ? $_POST['descuento'] : '';
$gimporte = (isset($_POST['gimporte'])) ? $_POST['gimporte'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO cxp_detalletmp (folio_cxp,id_item,cantidad,costo,importe,descuento,gimporte) 
                    values ('$folio','$iditem','$cantidad','$costo','$importe','$descuento','$gimporte')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from cxp_detalletmp where folio_cxp='$folio'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $subtotal=0;

        foreach ($data as $row) {
            $subtotal+=$row['gimporte'];
        }

        $consulta = "UPDATE cxptmp set subtotal='$subtotal' where folio_cxp='$folio'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from vcxp_detalletmp where folio_cxp='$folio' and id_item='$iditem'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


        break;
        case 2:
            $consulta = "DELETE FROM cxp_detalletmp where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
            $consulta = "SELECT * from cxp_detalletmp where folio_cxp='$folio'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $subtotal=0;
            foreach ($data as $row) {
                $subtotal+=$row['gimporte'];
            }
    
            $consulta = "UPDATE cxp_detalletmp set subtotal='$subtotal' where folio_cxp='$folio'";
            
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data=1;
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>