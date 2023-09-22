<?php
$vt = (isset($_POST['vt'])) ? $_POST['vt'] : 0;
$nmenseng = (isset($_POST['nmenseng'])) ? $_POST['nmenseng'] : 0;
$nmenssin = (isset($_POST['nmenssin'])) ? $_POST['nmenssin'] : 0;
$nmenscon = (isset($_POST['nmenscon'])) ? $_POST['nmenscon'] : 0;
$tinteres = (isset($_POST['tinteres'])) ? $_POST['tinteres'] : 0;
$fechaini = (isset($_POST['fechaini'])) ? new DateTime($_POST['fechaini']) : new DateTime();
$montoeng = (isset($_POST['montoeng'])) ? $_POST['montoeng'] : 0;

$montofin=$vt-$montoeng;

$tnmens=$nmenssin+$nmenscon;



$interes = ($tinteres/100)/12;
$datos = [];

$saldo = $vt;
$id=1;
for ($i = 1; $i <= ($nmenseng+$tnmens); $i++) {
    //inician los calculos
    if($i<=$nmenseng){
        $mensualidad = $montoeng / $nmenseng;
        $minteres=0;
        $tipo="ENG";
        $id=$i;
    }else{
        $mensualidad = round(($montofin / $tnmens),0);
        $id=$i-$nmenseng;
        if($i<=($nmenseng+$nmenssin)){
            $tipo="MSI";
            $minteres = 0;
        }
        else{
            $tipo="MCI";
            $minteres = round(($saldo * $interes),0);
        }
    }

    if($i==$tnmens+$nmenseng){
        $mensualidad=$saldo;
    }

    $saldo = $saldo - $mensualidad;

    $sumaTotal=$minteres + $mensualidad;
   
    $registro = [
        "id" => $id ,
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