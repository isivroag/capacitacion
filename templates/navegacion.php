<aside class="main-sidebar sidebar-dark-success elevation-4 ">
  <!-- Brand Logo -->

  <a href="inicio.php" class="brand-link">

    <img src="img/logob.png" alt="Bosque Logo" class="brand-image img-circle elevation-3" style="opacity: .8;background-color:white">
    <span class="brand-text font-weight-bold">TECNIEM</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
      <div class="image">
        <img src="img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['s_nombre']; ?></a>
        <input type="hidden" id="nameuser" name="nameuser" value="<?php echo $_SESSION['s_nombre']; ?>">
        <input type="hidden" id="fechasys" name="fechasys" value="<?php echo date('Y-m-d') ?>">
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item ">
          <a href="inicio.php" class="nav-link <?php echo ($pagina == 'home') ? "active" : ""; ?> ">
            <i class="nav-icon fas fa-home "></i>
            <p>
              Inicio
            </p>
          </a>
        </li>

        <?php if ($_SESSION['s_rol'] == '3' || $_SESSION['s_rol'] == '2' || $_SESSION['s_rol'] == '5') { ?>

          <li class="nav-item  has-treeview <?php echo ($pagina == 'items' ||  $pagina == 'cliente'  ||  $pagina == 'proveedor' ||  $pagina == 'caja' ||  $pagina == 'inmueble') ? "menu-open" : ""; ?>">
            <a href="#" class="nav-link  <?php echo ($pagina == 'items'  ||  $pagina == 'cliente'  ||  $pagina == 'proveedor' ||  $pagina == 'caja' ||  $pagina == 'inmueble') ? "active" : ""; ?>">
              <i class="nav-icon fas fa-bars "></i>
              <p>
                Catalogos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>


            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="cntacliente.php" class="nav-link <?php echo ($pagina == 'cliente') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-city nav-icon"></i>
                  <p>Clientes</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaproveedor.php" class="nav-link <?php echo ($pagina == 'proveedor') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-city nav-icon"></i>
                  <p>Proveedores</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntaitems.php" class="nav-link <?php echo ($pagina == 'items') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-road nav-icon"></i>
                  <p>Productos y Servicios</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="cntacaja.php" class="nav-link <?php echo ($pagina == 'caja') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-road nav-icon"></i>
                  <p>Cajas</p>
                </a>
              </li>
            </ul>

          </li>
        <?php } ?>

        <li class="nav-item has-treeview <?php echo ($pagina == 'cxp' || $pagina == 'cxc') ? "menu-open" : ""; ?>">
          <a href="#" class="nav-link <?php echo ($pagina == 'cxp' || $pagina == 'cxc') ? "active" : ""; ?>">

            <i class="fa-solid fa-file-lines nav-icon"></i>
            <p>
              Operaciones

              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">


            <li class="nav-item">
              <a href="cntacxp.php" class="nav-link <?php echo ($pagina == 'cxp') ? "active seleccionado" : ""; ?>  ">

                <i class="fa-regular fa-pen-to-square text-green  nav-icon"></i>
                <p>Compra</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntacxc.php" class="nav-link <?php echo ($pagina == 'cxc') ? "active seleccionado" : ""; ?>  ">

                <i class="fa-regular fa-pen-to-square text-green  nav-icon"></i>
                <p>Venta</p>
              </a>
            </li>

          </ul>
        </li>


        <li class="nav-item has-treeview <?php echo ($pagina == 'cntacobranza') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'cntacobranza') ? "active" : ""; ?>">

            <i class="fa-solid fa-magnifying-glass nav-icon"></i>
            <p>
              Consultas

              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">


            <li class="nav-item">
              <a href="cntacobranza.php" class="nav-link <?php echo ($pagina == 'cntacobranza') ? "active seleccionado" : ""; ?>  ">

                <i class="fa-solid fa-money-check-dollar   nav-icon"></i>
                <p>Cobranza</p>
              </a>
            </li>



          </ul>
        </li>


        <?php if ($_SESSION['s_rol'] == '3') {
        ?>
          <hr class="sidebar-divider">
          <li class="nav-item">
            <a href="cntausuarios.php" class="nav-link <?php echo ($pagina == 'usuarios') ? "active" : ""; ?> ">
              <i class="fas fa-user-shield"></i>
              <p>Usuarios</p>
            </a>
          </li>
        <?php
        }
        ?>

        <hr class="sidebar-divider">
        <li class="nav-item">
          <a class="nav-link" href="bd/logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <p>Salir</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<!-- Main Sidebar Container -->