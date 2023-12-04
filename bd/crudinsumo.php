<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$unidadm = (isset($_POST['unidadm'])) ? $_POST['unidadm'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$categoria = (isset($_POST['categoria'])) ? $_POST['categoria'] : '';

$fecha_alta = (isset($_POST['fecha_alta'])) ? $_POST['fecha_alta'] : '';




$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO insumo (clave,nombre,unidadm,cantidad,categoria,fecha_alta) 
        VALUES('$clave','$nombre','$unidadm','$cantidad','$categoria','$fecha_alta') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM insumo ORDER BY id_ins DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

        break;
    case 2: //modificación
        $consulta = "UPDATE insumo SET clave='$clave',nombre='$nombre',unidadm='$unidadm',cantidad='$cantidad',
        categoria='$categoria', fecha_alta='$fecha_alta' WHERE id_ins='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM insumo WHERE id_ins='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE insumo SET estado_ins=0 WHERE id_ins='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;