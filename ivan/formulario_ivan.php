<?php

$vt = (isset($_GET['vt'])) ? $_GET['vt'] : 0;
$nmens = (isset($_GET['nmens'])) ? $_GET['nmens'] : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php if ($vt == 0) { ?>
        <form method="get">
            <label for="vt">Valor Terreno:</label>
            <input type="text" id="vt" name="vt"><br><br>
            <label for="nmens">No. Mensualidades:</label>
            <input type="text" id="nmens" name="nmens"><br><br>
            <input type="submit" value="Submit">
        </form>
    <?php } else {
    ?>
        <table border="1px">
            <thead>
                <tr>
                    <th>MESUALIDAD</th>
                    <th>FECHA</th>
                    <th>CAPITAL</th>
                    <th>INTERES</th>
                    <th>MENSUALIDAD</th>
                    <th>SALDO</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $monto = $vt;
            $tasa = 16.15;
            $mensualidad = $monto / $nmens;
            $interes = ($tasa / 100) / 12;
            $fecha = date('d-m-Y');
            $saldo = $monto;
            for ($i = 1; $i <= $nmens; $i++) {
                //inician los calculos
                $minteres = $saldo * $interes;
                $saldo = $saldo - $mensualidad;

                echo "<tr>";
                echo "<td>" . $i . "</td>"; //N. MENS
                echo "<td>" . $fecha . "</td>"; //FECHA
                echo "<td>" . number_format($mensualidad, 2)  . "</td>"; //CAPITAL
                echo "<td>" . number_format($minteres, 2)  . "</td>"; //INTERES
                echo "<td>" . number_format($mensualidad + $minteres, 2)  . "</td>"; //MENSUALIDAD
                echo "<td>" . number_format($saldo, 2)  . "</td>"; //SALDO
                echo "</tr>";
                $fecha = date("d-m-Y", strtotime($fecha . " +1 month"));
            }
        } ?>

            </tbody>
        </table>


</body>

</html>