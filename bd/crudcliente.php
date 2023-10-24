<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$rfc = (isset($_POST['rfc'])) ? $_POST['rfc'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$dir = (isset($_POST['dir'])) ? $_POST['dir'] : '';
$cp = (isset($_POST['cp'])) ? $_POST['cp'] : '';
$tel = (isset($_POST['tel'])) ? $_POST['tel'] : '';
$celular = (isset($_POST['celular'])) ? $_POST['celular'] : '';
$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';


$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO cliente (rfc,nombre,direccion,cp,telefono,celular,correo) 
        VALUES('$rfc','$nombre','$dir','$cp','$tel','$celular','$correo') ";			
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM cliente ORDER BY id_cliente DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE cliente SET rfc='$rfc',nombre='$nombre',direccion='$dir',cp='$cp', telefono='$tel', celular='$celular',correo='$correo' WHERE id_cliente='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM cliente WHERE id_cliente='$id' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE cliente SET estado_cliente=0 WHERE id_cliente='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;        
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
