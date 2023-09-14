<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>MENSUALIDAD</th>
                <th>FECHA</th>
                <th>MONTO</th>
                <th>CAPITAL</th>
                <th>INTERES</th>
                <th>TOTAL</th>
                <th>SALDO</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $monto = 100000;
            $tasa = 16.15;
            $nmens = 20;
            $interes = (($tasa / 100) / 12);
            $fecha1 = date("d-m-Y");
            $mensualidad = $monto / $nmens;
            $saldo = $monto;

            for ($i = 1; $i <= $nmens; $i++) {
            ?>
                <?php
                //Inician los calculos
                $minteres = $saldo * $interes;
                $saldo = $saldo - $mensualidad;

                ?>
                <tr>

                    <td><?php echo $i ?></td>
                    <td><?php echo $fecha1 ?></td>
                    <td><?php echo number_format($monto, 2) ?></td>
                    <td><?php echo number_format($mensualidad, 2) ?></td>
                    <td><?php echo number_format($minteres, 2) ?></td>
                    <td><?php echo number_format($mensualidad + $minteres, 2) ?></td>
                    <td><?php echo number_format($saldo, 2) ?></td>

                </tr>

            <?php
                $fecha1 = date("d-m-Y", strtotime($fecha1 . "+1 month"));
            } ?>

        </tbody>

    </table>

</body>

</html>