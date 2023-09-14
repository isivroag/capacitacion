<?php

$valter= (isset($_POST["valter"])) ? $_POST["valter"] : 0;
$nmens= (isset($_POST["nmens"])) ? $_POST["nmens"] : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

<?php if ($valter == 0) { ?>
      <form method="post">
      <label for="valterr"> VALOR TERRENO:</label>
      <input name="valter" id="valter" type="text"> <br><br>
      <label for="nmens">NUMERO DE MENSUALIDADES:</label>
      <input name="nmens" id="nmens" type="text"> <br><br>
      <input type="submit" value="Enviar">

      
    </form>

    <?php
    }
    else {
  ?>
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

            $monto=$valter;
            $tasa = 16.15;
            $mensualidad = $monto / $nmens;
            $interes = ($tasa / 100) / 12;
            $fecha1 = date("d-m-Y");
            $saldo = $monto;

            for ($i = 1; $i <= $nmens; $i++) {
            
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
            } 

            } ?>

        </tbody>

    </table>
    
</body>
</html>