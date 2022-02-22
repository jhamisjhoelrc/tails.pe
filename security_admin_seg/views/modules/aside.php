<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="views/index3.html" class="brand-link">
    <img src="views/dist/img/template/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Tails</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php
        if ($_SESSION['photo_user'] != '') {
          echo '<img src="' . $_SESSION['photo_user'] . '" class="img-circle elevation-2" alt="User Image" />';
        } else {
          echo '<img src="views/dist/img/users/userDefault.jpg" class="img-circle elevation-2" alt="User Image" />';
        }

        ?>
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['names_user']; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="home" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <span class="right badge badge-danger">No</span>
            </p>
          </a>
        </li>
        <li class="nav-header">VENTAS</li>
        <li class="nav-item">
          <a href="sales" class="nav-link">
            <i class="nav-icon fas fa-boxes"></i>
            <p>
              Pedidos
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="customers" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Clientes
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="coupons" class="nav-link">
            <i class="nav-icon fas fa-shopping-basket"></i>
            <p>
              Cupones
            </p>
          </a>
        </li>
        <li class="nav-header">EXTRAS</li>
        <li class="nav-item">
          <a href="users" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Usuarios</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>