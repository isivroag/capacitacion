<?php
$vt = (isset($_POST['vt'])) ? $_POST['vt'] : 0;
$nmens = (isset($_POST['nmens'])) ? $_POST['nmens'] : 0;
$tinteres = (isset($_POST['tinteres'])) ? $_POST['tinteres'] : 0;
$fechaini = (isset($_POST['fechaini'])) ? new DateTime($_POST['fechaini']) : new DateTime();



$mensualidad = $vt / $nmens;
$interes = ($tinteres / 100) / 12;
$datos = [];

$saldo = $vt;

for ($i = 1; $i <= $nmens; $i++) {
    //inician los calculos
    $minteres = $saldo * $interes;
    $saldo = $saldo - $mensualidad;
    $sumaTotal=$minteres + $mensualidad;
    if ($minteres>0) {
        $tipo="MCI";
    }else
    {
        $tipo="";
    }    
    $registro = [
        "id" => $i ,
        "tipo"=>$tipo,
        "fecha" => $fechaini->format("Y-m-d"),
        "capital" => number_format($mensualidad, 2),
        "interes" => number_format($minteres, 2),
        "sumaTotal" => number_format($sumaTotal, 2),
        "saldo" => number_format($saldo, 2)
    ];
    $datos[] = $registro;

    $fechaini->add(new DateInterval("P1M"));
}
$jsonDatos = json_encode($datos);
echo $jsonDatos;
?>