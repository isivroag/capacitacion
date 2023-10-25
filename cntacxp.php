<?php
$pagina = "cxp";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM vcxp WHERE estado_cxp=1 ORDER BY folio_cxp";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->


  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header bg-gradient-green text-light">
        <h1 class="card-title mx-auto">CUENTAS POR PAGAR</h1>
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
                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                  <thead class="text-center bg-gradient-green">
                    <tr>
                      <th>FOLIO</th>
                      <th>FECHA</th>

                      <th>PROVEEDOR</th>
                      <th>DESCRIPCION</th>
                      <th>IMPORTE</th>
                      <th>SALDO</th>
                      <th>FOLIO T</th>
                      <th>ACCIONES</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($data as $dat) {
                    ?>
                      <tr>
                        <td><?php echo $dat['folio_cxp'] ?></td>
                        <td><?php echo $dat['fecha'] ?></td>
                        <td><?php echo $dat['nombre'] ?></td>
                        <td><?php echo $dat['descripcion'] ?></td>
                        <td class="text-right"><?php echo number_format($dat['gtotal'], 2) ?></td>
                        <td class="text-right"><?php echo number_format($dat['saldo'], 2) ?></td>
                        <td><?php echo $dat['folio_tmp'] ?></td>
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
      <!-- /.card-body -->

      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>

  <section class="content">
    <div class="" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-green">
            <h5 class="modal-title" id="exampleModalLabel">Pagos</h5>

          </div>
          <form id="formPago" action="" method="POST">
            <div class="modal-body">
              <div class="row justify-content-sm-between my-auto">

                <div class="col-sm-8 my-auto">
                  <div class="form-group input-group-sm">

                    <label for="banco" class="col-form-label">Banco Destino:</label>

                    <select class="form-control" name="banco" id="banco">
                      <?php
                      foreach ($datab as $regb) {
                      ?>
                        <option id="<?php echo $regb['id_banco'] ?>" value="<?php echo $regb['id_banco'] ?>"><?php echo $regb['nom_banco'] ?></option>
                      <?php
                      }
                      ?>

                    </select>
                  </div>
                </div>


                <div class="col-sm-3 my-auto">
                  <div class="form-group input-group-sm">
                    <label for="foliovp" class="col-form-label">Folio Venta:</label>
                    <input type="text" class="form-control" name="foliovp" id="foliovp" value="<?php echo $folio; ?>" disabled>
                  </div>
                </div>




                <div class="col-sm-3 my-auto">
                  <div class="form-group input-group-sm">
                    <label for="fechavp" class="col-form-label ">Fecha de Pago:</label>
                    <input type="date" id="fechavp" name="fechavp" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="Fecha">
                  </div>
                </div>
                <div class="col-sm-6 bg-gray-light rounded-lg">
                  <div class="row d-block">
                    <div class="d-flex d-flex justify-content-around">
                      <div class=" d-block custom-control custom-checkbox ">
                        <input class="custom-control-input" type="checkbox" id="ccliefact" name="ccliefact" value="">
                        <label for="ccliefact" class="custom-control-label">Cliente Solicito Fact.</label>
                      </div>

                      <div class="d-block custom-control custom-checkbox ">
                        <input class="custom-control-input" type="checkbox" id="facturado" name="facturado" value="">
                        <label for="facturado" class="custom-control-label">Facturar</label>
                      </div>
                    </div>
                  </div>
                  <div class="row" name="divfactura" id="divfactura" disabled>
                    <div class="col-sm-6">
                      <div class="form-group input-group-sm">
                        <label for="factura" class="col-form-label">No. Factura:</label>
                        <input type="text" class="form-control" name="factura" id="factura" value="<?php echo '0'; ?>" disabled>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group input-group-sm">
                        <label for="fechafact" class="col-form-label ">Fecha de Factura:</label>
                        <input type="date" id="fechafact" name="fechafact" class="form-control text-right" autocomplete="off" value="<?php echo date("Y-m-d") ?>" placeholder="Fecha Factura" disabled>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">

              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="conceptovp" class="col-form-label">Concepto Pago</label>
                    <input type="text" class="form-control" name="conceptovp" id="conceptovp" autocomplete="off" placeholder="Concepto de Pago">
                  </div>
                </div>
              </div>

              <div class="row justify-content-sm-center">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="obsvp" class="col-form-label">Observaciones:</label>
                    <textarea class="form-control" name="obsvp" id="obsvp" rows="3" autocomplete="off" placeholder="Observaciones"></textarea>
                  </div>
                </div>
              </div>

              <div class="row justify-content-sm-center">

                <div class="col-lg-4 ">
                  <label for="saldovp" class="col-form-label ">Saldo:</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-dollar-sign"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control text-right" name="saldovp" id="saldovp" value="<?php echo $saldo; ?>" disabled>
                  </div>
                </div>

                <div class="col-lg-4">
                  <label for="montopago" class="col-form-label">Pago:</label>
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-dollar-sign"></i>
                      </span>

                    </div>
                    <input type="text" id="montopago" name="montopago" class="form-control text-right" autocomplete="off" placeholder="Monto del Pago">
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="input-group-sm">
                    <label for="metodo" class="col-form-label">Metodo de Pago:</label>

                    <select class="form-control" name="metodo" id="metodo">
                      <option id="Efectivo" value="Efectivo">Efectivo</option>
                      <option id="Transferencia" value="Transferencia">Transferencia</option>
                      <option id="Deposito" value="Deposito">Deposito</option>
                      <option id="Cheque" value="Cheque">Cheque</option>
                      <option id="Tarjeta de Crédito" value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                      <option id="Tarjeta de Debito" value="Tarjeta de Débito">Tarjeta de Debito</option>

                    </select>
                  </div>
                </div>

              </div>

              <div class="row " name="divcomision" id="divcomision">
                <div class="col-sm-12 ">

                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group input-group-sm">
                        <label for="porcom" class="col-form-label">% Comisión:</label>
                        <input type="text" class="form-control" name="porcom" id="porcom" value="" placeholder="% Comisión">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group input-group-sm">
                        <label for="comision" class="col-form-label ">Monto Comisión:</label>
                        <input type="text" id="comision" name="comision" class="form-control text-right" autocomplete="off" value="" placeholder="Monto Comisión">
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group input-group-sm">
                        <label for="montopagoc" class="col-form-label ">Monto a Pagar:</label>
                        <input type="text" id="montopagoc" name="montopagoc" class="form-control text-right" autocomplete="off" value="" placeholder="Monto a Pagar">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>





            <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button" id="btnGuardarvp" name="btnGuardarvp" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>


  <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>

<script src="fjs/cntacxp.js?v=<?php echo (rand()); ?>"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>