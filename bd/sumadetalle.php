<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$total = 0;



        $consulta = "SELECT gimporte from cxp_detalletmp
                    where folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $subtotal=0;
        foreach ($data as $row) {
            $subtotal+=$row['gimporte'];
        }


 

print json_encode($subtotal, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
