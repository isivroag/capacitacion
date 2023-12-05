<?php
$pagina = "consumo";
$opcion = 0;

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

$objeto = new conn();
$conexion = $objeto->connect();
$usuario = $_SESSION['s_nombre'];

if ($folio != "") {

    $opcion = 2;
    $consulta = "SELECT * FROM consumo where folio_cons='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {

        $folio =  $dt['folio_cons'];
        $fecha = $dt['fecha'];
        $responsable = $dt['responsable'];
        $evento =  $dt['evento'];
        $obs = $dt['obs'];
        $fecha_salida = $dt['fecha_salida'];
    }


    $message = "";
} else {

    //BUSCAR CUENTA ABIERTA

    $consultatmp = "SELECT * FROM consumo WHERE usuario='$usuario' and activo='0' ORDER BY folio_cons DESC LIMIT 1";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();
    if ($resultadotmp->rowCount() >= 1) {
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    } else {

        // INSERTAR FOLIO NUEVO

        $fecha = date('Y-m-d');
        $consultatmp = "INSERT INTO consumo (usuario,fecha) VALUES('$usuario', '$fecha')";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();


        $consultatmp = "SELECT * FROM consumo WHERE usuario= '$usuario' and activo='0' ORDER BY folio_cons DESC LIMIT 1";
        $resultadotmp = $conexion->prepare($consultatmp);
        $resultadotmp->execute();
        $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    }

    foreach ($datatmp as $dt) {

        $folio =  $dt['folio_cons'];
        $opcion = 1;
        $fecha = $dt['fecha'];
        $responsable = $dt['responsable'];
        $evento =  $dt['evento'];
        $obs = $dt['obs'];
        $fecha_salida = $dt['fecha_salida'];
    }
}

$consultaitem = "SELECT * FROM insumo WHERE estado_ins=1 ORDER BY id_ins";
$resultadoitem = $conexion->prepare($consultaitem);
$resultadoitem->execute();
$dataitem = $resultadoitem->fetchAll(PDO::FETCH_ASSOC);

?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<style>
    .borde-titulogris {
        border-left: grey;
        border-style: outset;
        ;
    }

    .fondogris {
        background-color: rgba(183, 185, 187, .8);
    }

    .borde-titulazul {
        border-left: rgb(117, 74, 195);
        border-style: outset;
        ;
    }

    .fondoazul {
        background-color: rgba(117, 74, 195, 0.8);
    }

    .borde-titulinfo {
        border-left: rgb(23, 162, 184);
        border-style: outset;
        ;
    }

    .fondoinfo {
        background-color: rgba(23, 162, 184, .8);
    }

    .borde-titulpur {
        border-left: rgb(117, 74, 195);
        border-style: outset;
        ;
    }

    .fondopur {
        background-color: rgba(117, 74, 195, .8);
    }




    .punto {
        height: 20px !important;
        width: 20px !important;

        border-radius: 50% !important;
        display: inline-block !important;
        text-align: center;
        font-size: 15px;
    }

    .div_carga {
        position: absolute;
        /*top: 50%;
    left: 50%;
    */

        width: 100%;
        height: 100%;
        background-color: rgba(60, 60, 60, 0.5);
        display: none;

        justify-content: center;
        align-items: center;
        z-index: 3;
    }

    .cargador {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        margin-left: -25px;
    }

    .textoc {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: 120px;
        margin-left: 20px;


    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- FOMRULARIO ALTA CXP -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-gradient-secondary text-light">
                <h1 class="card-title mx-auto">INVENTARIO</h1>
            </div>

            <div class="card-body">
                <?php
                if ($opcion == 1) {
                ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                        </div>
                    </div>
                <?php
                }
                ?>

                <br>



                <form id="formDatos" action="" method="POST">


                    <div class="content" disab>

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-secondary " style="margin:0px;padding:8px">

                                <h1 class="card-title ">VALE DE CONSUMO</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center">

                                    <div class="col-sm-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folio" class="col-form-label">Folio:</label>
                                            <input type="text" class="form-control" name="folio" id="folio" value="<?php echo $folio; ?>">

                                        </div>
                                    </div>
                                    <div class="col-sm-5"></div>


                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha de Alta:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha_salida" class="col-form-label">Fecha de Salida:</label>
                                            <input type="date" class="form-control" name="fecha_salida" id="fecha_salida" value="<?php echo $fecha_salida; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-sm-center">
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
                                            <input type="hidden" class="form-control" name="opcion" id="opcion" value="<?php echo $opcion; ?>">

                                            <label for="responsable" class="col-form-label">Responsable:</label>
                                            <input type="text" class="form-control" name="responsable" id="responsable" value="<?php echo $responsable; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label for="evento" class="col-form-label">Evento:</label>
                                            <input type="text" class="form-control" name="evento" id="evento" value="<?php echo $evento; ?>">


                                        </div>
                                    </div>
                                </div>



                                <div class=" row justify-content-sm-center">
                                    <div class="col-sm-10">

                                        <div class="form-group">
                                            <label for="obs" class="col-form-label">Observaciones:</label>
                                            <textarea rows="2" class="form-control" name="obs" id="obs"><?php echo $obs; ?></textarea>
                                        </div>

                                    </div>



                                </div>
                                <div class="row justify-content-sm-center m-auto" style="padding:5px 0px;margin-bottom:5px">
                                    <div class="col-sm-10">
                                        <div class="card ">

                                            <div class="card-header bg-secondary " style="margin:0px;padding:8px">
                                                <div class="card-tools" style="margin:0px;padding:0px;">
                                                </div>

                                                <h1 class="card-title text-light">INSUMOS</h1>
                                                <div class="card-tools" style="margin:0px;padding:0px;">
                                                </div>
                                            </div>

                                            <div class="card-body" style="margin:0px;padding:3px;">

                                                <?php
                                                if ($opcion == 1) {
                                                ?>

                                                    <div class="card card-widget collapsed-card " style="margin:2px;padding:5px;">
                                                        <div class="card-header " style="margin:0px;padding:8px;">

                                                            <button type="button" class="btn bg-gradient-secondary btn-sm" id="bntAgregar" name="bntAgregar">
                                                                Agregar Insumo <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>

                                                    </div>
                                                <?php }
                                                ?>

                                                <div class="row">

                                                    <div class="col-lg-12 mx-auto">
                                                        <div class="table-responsive" style="padding:5px;">
                                                            <table name="tablaDet" id="tablaDet" class="table table-sm table-striped table-bordered table-condensed text-nowrap mx-auto" style="width:100%;font-size:15px">
                                                                <thead class="text-center bg-gradient-secondary">
                                                                    <tr>
                                                                        <th>Id Reg</th>
                                                                        <th>Id Ins</th>
                                                                        <th>Clave </th>
                                                                        <th>Descripcion</th>
                                                                        <th>Cantidad</th>
                                                                        <th>UMedida</th>
                                                                        <th>Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $consulta = "SELECT * FROM vconsumo_det WHERE folio_cons='$folio'";
                                                                    $resultado = $conexion->prepare($consulta);
                                                                    $resultado->execute();
                                                                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                                                    foreach ($data as $rowdet) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?php echo $rowdet['id_reg'] ?></td>
                                                                            <td><?php echo $rowdet['id_ins'] ?></td>
                                                                            <td><?php echo $rowdet['clave'] ?></td>
                                                                            <td><?php echo $rowdet['nombre'] ?></td>
                                                                            <td><?php echo $rowdet['cantidad'] ?></td>
                                                                            <td><?php echo $rowdet['unidadm'] ?></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>

                                                        </div>

                                                    </div>

                                                </div>




                                            </div>

                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </form>



                <!-- MATERIALES USADOS-->

                <!-- TERMINA MATERIALES USADOS -->
            </div>

        </div>
    </section>
    <!-- TERMINA ALTA CXP -->




    <!-- TABLA CONCEPTOS -->
    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalArticulo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-secondary">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR CONCEPTOS</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaArticulo" id="tablaArticulo" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center bg-gradient-primary">
                                    <tr>

                                        <th>Id_Ins</th>
                                        <th>Clave</th>
                                        <th>Descripción</th>
                                        <th>Existencias</th>
                                        <th>Unidad de medida</th>
                                        <th>Seleccionar</th>
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
    <!-- TERMINA CONCEPTOS -->


    <section>
        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">AGREGAR INSUMO</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body ">

                                <div class="row justify-content-center">
                                    <div class="col-sm-6">
                                        <div class="form-group input-group-sm">
                                            <label for="clave" class="col-form-label">CLAVE:</label>
                                            <input type="text" class="form-control" name="clave" id="clave" autocomplete="off" placeholder="CLAVE" disabled>
                                            <input type="hidden" class="form-control" name="idins" id="idins" autocomplete="off" placeholder="CLAVE" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group input-group-sm">
                                            <label for="existencia" class="col-form-label">EXISTENCIAS:</label>
                                            <input type="text" class="form-control" name="existencia" id="existencia" autocomplete="off" placeholder="EXISTENCIAS" disabled>
                                        </div>

                                    </div>

                                </div>

                                <div class="row justify-content-center">

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="nombre" class="col-form-label">DESCRIPCION:</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off" placeholder="DESCRIPCION" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">


                                    <div class="col-sm-6">
                                        <div class="form-group input-group-sm">
                                            <label for="cantidad" class="col-form-label">CANTIDAD:</label>
                                            <input type="text" class="form-control" name="cantidad" id="cantidad" autocomplete="off" placeholder="CANTIDAD">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group input-group-sm">
                                            <label for="unidadm" class="col-form-label">UNIDAD DE MEDIDA:</label>
                                            <input type="text" class="form-control" name="unidadm" id="unidadm" autocomplete="off" placeholder="UNIDAD DE MEDIDA" disabled>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="row justify-content-end">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                    <button type="button" id="btnGuardarIn" name="btnGuardarIn" class="btn btn-success" value="btnGuardarIn"><i class="far fa-save"></i> Guardar</button>
                                </div>

                            </div>


                        </form>
                    </div>

                </div>





            </div>
        </div>

    </section>

    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/consumo.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>