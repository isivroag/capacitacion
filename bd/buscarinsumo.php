<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();;
$data = 0;

$consulta = "SELECT * FROM insumo WHERE estado_ins=1 ORDER BY id_ins";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);


print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
