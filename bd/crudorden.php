<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';

$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$proveedor = (isset($_POST['proveedor'])) ? $_POST['proveedor'] : '';
$id_proy = (isset($_POST['id_proy'])) ? $_POST['id_proy'] : '';
$proyecto = (isset($_POST['proyecto'])) ? $_POST['proyecto'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';

$total = (isset($_POST['total'])) ? $_POST['total'] : '';
$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res = 0;


switch ($opcion) {
    case 1: //alta
        $consulta = "UPDATE orden set fecha='$fecha',id_prov='$id_prov',nom_prov='$proveedor',id_proyecto='$id_proy',nom_proy='$proyecto',concepto='$concepto',
        total='$total',activo='1' WHERE folio_ord='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;
// consulto la tabla temporal y uso los campos o columnas en variables
//inserto en la tabla definitiva estas variables el folio no , folio me lo va a generar la tablar al terminar el insert
//consulto el ultimo registro de la tabla definitiva para ver que folio me toco
//consulto todos los registros del detalle de compra temporal
//y mientras los recorro todo los datos de cada renglo, los meto en variables y hago un insert a la tabla defintiva del detalle de compra
//esto n numero de veces hasta terminar de recorrer la tabla temporal del detalle de compra.




        

        $consulta= "SELECT * from cxp_detalletmp where folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

  foreach($data as $dat){
        $id_item=$dat['id_item'];

        $consulta2="INSERT INTO cxp_detalle(folio_cxp,id_item) values($foliodefini,'$id_item')";
        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();

  }
            //TERMINA EL INCREMENTO EN INVENTARIO   



        break;
    case 2:


        break;

    case 3:
        $consulta = "UPDATE cxp SET estado_cxp='0' WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        // CONSULTA DEL DETALLE
        $consulta = "SELECT * FROM detallecxp_herramienta WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {

            // EMPIEZA EL INCREMENTO EN INVENTARIO
            $id = $row['id_her'];
            $tipomov = 'Salida Can';
            $saldo = 0;
            $montomov = $row['cant_her'];
            $saldofin = 0;
            $descripcion = "CANCELACION DE COMPRA DE HERRAMIENTA CXP FOLIO: ". $folio;
            
            $usuario=$row['usuario'];
            
         
            $consultam = "SELECT * from herramienta where id_her='$id'";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $datam = $resultadom->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datam as $rowdatam) {
                    $saldo = $rowdatam['cant_her'];
                }
                $res += 1;
            }

            $saldofin = $saldo - $montomov;

            //guardar el movimiento
            $consultam = "INSERT INTO mov_herramienta(id_her,fecha_movh,tipo_movh,cantidad,saldoini,saldofin,descripcion,usuario) values('$id','$fecha_actual','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario')";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $res += 1;
            }

            $consultam = "UPDATE herramienta SET cant_her='$saldofin' WHERE id_her='$id'";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $res += 1;
            }
            //TERMINA EL INCREMENTO EN INVENTARIO   

        }


        
        break;
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
