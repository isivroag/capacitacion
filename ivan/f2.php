<?php
date_default_timezone_set('America/Mexico_City');



?>


<link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="../css/adminlte.css">
<link rel="stylesheet" href="../css/estilo.css?v=<?php echo (rand()); ?>">
<script src="https://kit.fontawesome.com/f1fe472df3.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../css/estilo.css">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-navy">
                            <div class="row justify-content-center">
                                <h3 class="card-title">Cotizador</h3>
                            </div>
                          
                        </div>
                        <div class="card-body">

                            <form method="get">

                                <div class="row justify-content-center">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="vt">Valor Terreno:</label>
                                            <input type="text" class="form-control" id="vt" name="vt"  placeholder="Valor Terreno">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="nmens">No. Mensualidades:</label>
                                            <input type="number" class="form-control" id="nmens" name="nmens"  placeholder="# Mensualidades">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="tinteres">Tasa de Interes:</label>
                                            <input type="text" class="form-control" id="tinteres" name="tinteres"  placeholder="Tasa de Interes">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="fechaini">Fecha Inicio:</label>
                                            <input type="date" class="form-control" id="fechaini" name="fechaini"  placeholder="Fecha Inicio">
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-sm-12">
                                        <input type="button" class="btn-success btn-block" value="Calcular" id="btnCalcular">
                                    </div>
                                </div>

                            </form>
                        
                                <table class="table table-borderer table-sm table-condensed table-hover" name="tabla" id="tabla">
                                    <thead class="bg-gradient-navy">
                                        <tr>
                                            <th class="text-center">MESUALIDAD</th>
                                            <th class="text-center">FECHA</th>
                                            <th class="text-center">CAPITAL</th>
                                            <th class="text-center">INTERES</th>
                                            <th class="text-center">TOTAL</th>
                                            <th class="text-center">SALDO</th>
                                            <th class="text-center">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                    </tbody>
                                </table>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</body>



<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../fjs/f2.js?v=<?php echo (rand()); ?>"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../js/adminlte.min.js"></script>
<script src="../js/demo.js"></script>





<script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>

</html>

