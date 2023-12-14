<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();;
$data = 0;
$id_ins = (isset($_POST['id_ins'])) ? $_POST['id_ins'] : '';
$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$consulta = "SELECT * FROM consumo_det WHERE folio_cons='$folio' and id_ins='$id_ins'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
if ($resultado ->rowCount()!= 0){
    $data = 1;
}


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
