<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : '';
$referencia = (isset($_POST['referencia'])) ? $_POST['referencia'] : '';




$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO articulo (clave,nombre,cantidad,categoria,referencia) 
        VALUES('$clave','$nombre','$cantidad','$categoria','$referencia') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM articulo ORDER BY id_art DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

        break;
    case 2: //modificación
        $consulta = "UPDATE articulo SET clave='$clave',nombre='$nombre',cantidad='$cantidad',
        categoria='$categoria', referencia='$referencia' WHERE id_art='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM articulo WHERE id_art='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE articulo SET estado_art=0 WHERE id_art='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;