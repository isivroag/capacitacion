<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$id_art= (isset($_POST['id_art'])) ? $_POST['id_art'] : '';
$opcion= (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO prestamo_det (folio_pres,id_art) 
                    values ('$folio','$id_art')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        $consulta = "SELECT * from vprestamo_det where folio_pres='$folio' and id_art='$id_art'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        

        


        break;
        case 2:
 

            $data=1;
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>