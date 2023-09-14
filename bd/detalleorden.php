<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$idcon = (isset($_POST['idcon'])) ? $_POST['idcon'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$costo = (isset($_POST['costo'])) ? $_POST['costo'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$unidad = (isset($_POST['unidad'])) ? $_POST['unidad'] : '';
$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO orden_detalle (folio_ord,id_concepto,concepto,cantidad,precio,monto,unidad,clave) 
                    values ('$folio','$idcon','$concepto','$cantidad','$costo','$subtotal','$unidad','$clave')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from orden_detalle where folio_ord='$folio'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $total=0;
        foreach ($data as $row) {
            $total+=$row['monto'];
        }

        $consulta = "UPDATE orden set total='$total' where folio_ord='$folio'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from orden_detalle where folio_ord='$folio' and id_concepto='$idcon'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


        break;
        case 2:
            $consulta = "DELETE FROM orden_detalle where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
            $consulta = "SELECT * from orden_detalle where folio_ord='$folio'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $total=0;
            foreach ($data as $row) {
                $total+=$row['monto'];
            }
    
            $consulta = "UPDATE orden set total='$total' where folio_ord='$folio'";
            
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            $data=1;
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>