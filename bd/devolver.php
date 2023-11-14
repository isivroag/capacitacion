<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$idreg = (isset($_POST['idreg'])) ? $_POST['idreg'] : '';
$foliopres = (isset($_POST['foliopres'])) ? $_POST['foliopres'] : '';
$idart = (isset($_POST['idart'])) ? $_POST['idart'] : '';
$fecha_baja = (isset($_POST['fecha_baja'])) ? $_POST['fecha_baja'] : '';
$estado = (isset($_POST['estado'])) ? $_POST['estado'] : '';
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : '';
$res=0;


$consulta = "UPDATE prestamo_det set prestado=0, devuelto='$estado',obs='$obs' WHERE id_reg='$idreg'";
$resultado = $conexion->prepare($consulta);
if ($resultado->execute()){
    if ($estado==0){
        $consulta = "UPDATE articulo set prestado=0, fecha_baja='$fecha_baja' WHERE id_art='$idart'";
    }
    else{
        $consulta = "UPDATE articulo set prestado=0 WHERE id_art='$idart'";
    }
    $resultado = $conexion->prepare($consulta);
    if ($resultado->execute()){
        $res = 1;
    }

    $consulta = "SELECT * FROM prestamo_det WHERE prestado<>0 and folio_pres='$foliopres'" ;
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    if($resultado->rowCount()==0){
        $consulta = "UPDATE prestamo SET estado='FINALIZADO' WHERE folio_pres='$foliopres'" ;
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res=2;
    }
    
    
}








print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
