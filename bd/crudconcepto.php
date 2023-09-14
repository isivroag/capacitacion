<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';

$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$unidad = (isset($_POST['unidad'])) ? $_POST['unidad'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_concepto (clave_concepto,nom_concepto,unidad) VALUES('$clave','$concepto','$unidad') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $data=1;
        break;
    case 2: //modificación
        $consulta = "UPDATE w_concepto SET clave_concepto='$clave',nom_concepto='$concepto',unidad='$unidad' WHERE id_concepto='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
      
        $data=1;
        break;        
    case 3://baja
        $consulta = "UPDATE w_concepto SET estado_concepto=0 WHERE id_concepto='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
