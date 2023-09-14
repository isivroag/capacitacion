<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$total = 0;



        $consulta = "SELECT monto from orden_detalle 
                    where folio_ord='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        $total=0;
        foreach ($data as $row) {
            $total+=$row['monto'];
        }


 

print json_encode($total, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
