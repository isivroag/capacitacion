<?php

$valter = (isset($_POST["valter"])) ? $_POST["valter"] : 0;
$nmens = (isset($_POST["nmens"])) ? $_POST["nmens"] : 0;

?>

<link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="../css/adminlte.css">
<link rel="stylesheet" href="../css/estilo.css?v=<?php echo (rand()); ?>">
<script src="https://kit.fontawesome.com/f1fe472df3.js" crossorigin="anonymous"></script>

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
            <label for="valter"> VALOR TERRENO:</label>
            <input name="valter" id="valter" type="text"> <br><br>
            <label for="nmens">NUMERO DE MENSUALIDADES:</label>
            <input name="nmens" id="nmens" type="text"> <br><br>
            <input type="submit" value="Enviar">


        </form>

    <?php
    } else {
    ?>
        <table class="table table-borderer table-condensed table-hover"> 
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

                $monto = $valter;
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

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../js/demo.js"></script>