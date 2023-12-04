<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$id_ins = (isset($_POST['id_ins'])) ? $_POST['id_ins'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$data = 0;


switch ($opcion) {
    case 1: //alta
        $consulta = "SELECT * FROM consumo_det where folio_cons=$folio and id_ins='$id_ins'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        if ($resultado->rowCount() == 0) {
            $consulta = "INSERT INTO consumo_det (folio_cons,id_ins) 
            values ('$folio','$id_ins')";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();

            /*$consulta = "UPDATE articulo set prestado = 1 where id_art='$id_art'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();*/

            $consulta = "SELECT * from vconsumo_det where folio_cons='$folio' and id_ins='$id_ins'";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        }


        break;

    case 2:
        /*$consulta = "UPDATE articulo set prestado = 0 where id_art='$id_art'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();*/


        $consulta = "DELETE FROM consumo_det WHERE folio_cons='$folio' and id_ins='$id_ins'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()){
            $data=1;
        }

       
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
