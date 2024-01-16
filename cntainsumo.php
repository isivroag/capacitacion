<?php
$pagina = "cntainsumo";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";

include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM insumo WHERE estado_ins=1 ORDER BY id_ins";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$consultau = "SELECT * FROM umedida WHERE estado_umed=1 ORDER BY id_umed";
$resultadou = $conexion->prepare($consultau);
$resultadou->execute();
$datau = $resultadou->fetchAll(PDO::FETCH_ASSOC);

$consultac = "SELECT * FROM categoria WHERE estado_cat=1 ORDER BY id_cat";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);




?>



<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->



    <section class="content">


        <div class="card">
            <div class="card-header bg-gradient-green text-light">
                <h1 class="card-title mx-auto">INSUMOS</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-gradient-green btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>

                    </div>
                </div>
                <br>


                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table name="tabla1" id="tabla1" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-green">
                                        <tr>
                                            <th>ID</th>
                                            <th>CLAVE</th>
                                            <th>DESCRIPCION</th>
                                            <th>U. DE MEDIDA</th>
                                            <th>CANTIDAD</th>
                                            <th>CATEGORIA</th>
                                            <th>FECHA ALTA</th>
                                            <th>FECHA BAJA</th>

                                            <th>ACCIONES</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_ins'] ?></td>
                                                <td><?php echo $dat['clave'] ?></td>
                                                <td><?php echo $dat['nombre'] ?></td>
                                                <td><?php echo $dat['unidadm'] ?></td>
                                                <td><?php echo $dat['cantidad'] ?></td>
                                                <td><?php echo $dat['categoria'] ?></td>

                                                <td><?php echo $dat['fecha_alta'] ?></td>
                                                <td><?php echo $dat['fecha_baja'] ?></td>

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


    </section>

    <!-- PRODUCTOS Y SERVICIOS -->
    <section>
        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-green">
                        <h5 class="modal-title" id="exampleModalLabel">NUEVO INSUMO</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body ">

                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="clave" class="col-form-label">CLAVE:</label>
                                            <input type="text" class="form-control" name="clave" id="clave" autocomplete="off" placeholder="CLAVE">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4">

                                        <div class="form-group input-group-sm">
                                            <label for="fecha_alta" class="col-form-label">Fecha Alta:</label>
                                            <input type="date" class="form-control" name="fecha_alta" id="fecha_alta" autocomplete="off" placeholder="fecha_alta">
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">

                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="nombre" class="col-form-label">DESCRIPCION:</label>
                                            <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off" placeholder="DESCRIPCION">
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="umedida" class="col-form-label">U DE MEDIDA:</label>
                                            <select class="form-control" name="umedida" id="umedida" autocomplete="off" placeholder="u de medida">
                                                <?php
                                                foreach ($datau as $datu) {
                                                ?>
                                                    <option value="<?php echo $datu['nombre'] ?>"> <?php echo $datu['nombre'] ?></option>
                                                <?php  } ?>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="cantidad" class="col-form-label">CANTIDAD:</label>
                                            <input type="text" class="form-control" name="cantidad" id="cantidad" autocomplete="off" placeholder="CANTIDAD">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="categoria" class="col-form-label">CATEGORIA:</label>
                                            <select class="form-control" name="categoria" id="categoria" autocomplete="off" placeholder="categoria">
                                                <?php
                                                foreach ($datac as $datc) {
                                                ?>
                                                    <option value="<?php echo $datc['nombre'] ?>"> <?php echo $datc['nombre'] ?></option>
                                                <?php  } ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <div class="row justify-content-end">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                    <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
                                </div>

                            </div>

                        </form>

                    </div>





                </div>
            </div>
        </div>

    </section>

    <section>
        <div class="modal fade" id="modalMOV" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-secondary">
                        <h5 class="modal-title" id="exampleModalLabel">MOVIMIENTOS DE INVENTARIO</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formMov" action="" method="POST">
                            <div class="modal-body row">
                                <div class="col-sm-2">
                                    <div class="form-group input-group-sm">
                                        <label for="idm" class="col-form-label">ID:</label>
                                        <input type="text" class="form-control" name="idm" id="idm" autocomplete="off" placeholder="ID" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group input-group-sm">
                                        <label for="nombrem" class="col-form-label">Insumo:</label>
                                        <input type="text" class="form-control" name="nombrem" id="nombrem" autocomplete="off" placeholder="Nombre/Descripción" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-2">


                                    <div class="form-group input-group-sm">
                                        <label for="extm" class="col-form-label">Existencias:</label>
                                        <input type="text" class="form-control text-right" name="extm" id="extm" value="" placeholder="Existencias" disabled>
                                    </div>
                                </div>



                               



                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="descripcion" class="col-form-label">Descripción del Movimiento:</label>
                                        <textarea rows="2" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción del Movimiento"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm auto">
                                        <label for="tipomov" class="col-form-label">Tipo Movimiento:</label>
                                        <select class="form-control" name="tipomov" id="tipomov">
                                            <option id="Inventario Inicial" value="Inventario Inicial"> Inventario Inicial</option>
                                            <option id="Entrada" value="Entrada"> Entrada</option>
                                            <option id="Salida" value="Salida"> Salida</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="montom" class="col-form-label">Cantidad Movimiento:</label>
                                        <input type="text" class="form-control text-right" name="montom" id="montom" value="" placeholder="Cantidad Movimiento">
                                    </div>


                                </div>

                            </div>
                           
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                                <button type="submit" id="btnGuardarM" name="btnGuardarM" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
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

<script src="fjs/cntainsumo.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="http://cdn.datatables.net/plug-ins/1.10.21/sorting/formatted-numbers.js"></script>