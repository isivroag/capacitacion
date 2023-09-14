<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   
$id_proyecto = (isset($_POST['id_proyecto'])) ? $_POST['id_proyecto'] : '';

$clave = (isset($_POST['clave'])) ? $_POST['clave'] : '';

$id_emp = (isset($_POST['id_emp'])) ? $_POST['id_emp'] : '';
$empresa = (isset($_POST['empresa'])) ? $_POST['empresa'] : '';

$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';



switch($opcion){
    case 1: //alta
        $consulta = "INSERT INTO w_proyecto (clave_proy,nom_proy,id_emp,razon_emp) VALUES('$clave','$nombre','$id_emp','$empresa') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 

        $consulta = "SELECT * FROM w_proyecto ORDER BY id_emp DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        $consulta = "UPDATE w_proyecto SET clave_proy='$clave',nom_proy='$nombre',id_emp='$id_emp',razon_emp='$empresa' WHERE id_proy='$id_proyecto' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM w_proyecto WHERE id_proy='$id_proyecto' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;        
    case 3://baja
        $consulta = "UPDATE w_proyecto SET estado_proy=0 WHERE id_proy='$id_proyecto' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        $data=1;                          
        break;   
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
