<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" type="image/png" href="views/dist/img/template/icon.png">
  <title>Sistema - Grupo Activa</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="views/plugins/fontawesome-free/css/all.min.css">
  <!-- Jquery UI -->
  <link rel="stylesheet" href="views/plugins/new-jquery-ui/jquery-ui.css" />
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="views/dist/css/adminlte.min.css">
  <!-- Datatables -->
  <link rel="stylesheet" href="views/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="views/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Date picker bootstrap -->
  <link rel="stylesheet" href="views/plugins/bootstrap-datapicker/css/bootstrap-datepicker.css" />
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="views/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="views/plugins/select2/css/select2.min.css" />
  <link rel="stylesheet" href="views/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css" />
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="views/dist/css/styles.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>


    <?php
        if (isset($_SESSION["loginSession"]) && $_SESSION["loginSession"] == "enabled") {
            echo '<body class="hold-transition sidebar-mini sidebar-collapse">';
            echo '<div class="wrapper">';
            /* <!-- Navbar --> */
                include 'modules/navbar.php';
            /* <!-- /.navbar --> */

            /* <!-- Main Sidebar Container --> */
            include 'modules/aside.php'; 
            /* <!-- Content Wrapper. Contains page content --> */
            if(isset($_GET['route'])){
                if($_GET['route'] == "home" ||
                    $_GET['route'] == "logout" ||
                    $_GET['route'] == "users" ||
                    $_GET['route'] == "sellers" ||
                    $_GET['route'] == "subsidiarys" ||
                    $_GET['route'] == "providers" ||
                    $_GET['route'] == "imports" ||
                    $_GET['route'] == "addImports" ||
                    $_GET['route'] == "editImports" ||
                    $_GET['route'] == "nationals" ||
                    $_GET['route'] == "addNational" ||
                    $_GET['route'] == "editNational" ||
                    $_GET['route'] == "paymentProviders" ||
                    $_GET['route'] == "customers" ||
                    $_GET['route'] == "sales" ||
                    $_GET['route'] == "addSales" ||
                    $_GET['route'] == "editSales" ||
                    $_GET['route'] == "showSale" ||
                    $_GET['route'] == "notas" ||
                    $_GET['route'] == "addNota" ||
                    $_GET['route'] == "showNota" ||
                    $_GET['route'] == "addGuia" ||
                    $_GET['route'] == "addGuiaRemision" ||
                    $_GET['route'] == "guiasRemision" ||
                    $_GET['route'] == "showGuia" ||
                    $_GET['route'] == "moviles" ||
                    $_GET['route'] == "exchange" ||
                    $_GET['route'] == "coupons" ||
                    $_GET['route'] == "assemblers"
                ){
                    include 'modules/'.$_GET['route'].'.php'; 
                } else {
                    include 'modules/404.php'; 
                }
            } else {
                include 'modules/home.php'; 
            }
            
            /* <!-- /.content-wrapper --> */
            /* <!-- Footer --> */
            include 'modules/footer.php';
            /* <!-- Fin de footer --> */
            echo '</div>';
        } 
        else {
            echo '<body class="hold-transition sidebar-mini login-page sidebar-collapse">';
            include "modules/login.php";
        }
    ?>
  
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="views/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Jquery UI -->
<script src="views/plugins/new-jquery-ui/jquery-ui.js"></script>
<!-- AdminLTE App -->
<script src="views/dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="views/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Script Date picker bootstrap -->
<script src="views/plugins/bootstrap-datapicker/js/bootstrap-datepicker.min.js"></script>
<script src="views/plugins/bootstrap-datapicker/locales/bootstrap-datepicker.es.min.js"></script>
<!-- Sweet Alert -->
<script src="views/plugins/sweetAlert/sweetalert2.all.min.js"></script>
<!-- Select2 -->
<script src="views/plugins/select2/js/select2.full.min.js"></script>
<!-- Script plantilla -->
<script src="views/dist/js/app.js"></script>
<!-- Script Users -->
<script src="views/dist/js/users.js"></script>
<!-- Script Sellers -->
<script src="views/dist/js/sellers.js"></script>
<!-- Script Subsidiarys -->
<script src="views/dist/js/subsidiarys.js"></script>
<!-- Script Providers -->
<script src="views/dist/js/providers.js"></script>
<!-- Script Imports -->
<script src="views/dist/js/imports.js"></script>
<!-- Script Nationals -->
<script src="views/dist/js/nationals.js"></script>
<!-- Script Customers -->
<script src="views/dist/js/customers.js"></script>
<!-- Script Sales -->
<script src="views/dist/js/sales.js"></script>
<!-- Script Notas -->
<script src="views/dist/js/notas.js"></script>
<!-- Script Guia -->
<script src="views/dist/js/guia.js"></script>
<!-- Script Moviles -->
<script src="views/dist/js/moviles.js"></script>
<!-- Script Exchange -->
<script src="views/dist/js/exchange.js"></script>
<!-- Script Models -->
<script src="views/dist/js/models.js"></script>
<!-- Script assemblers -->
<script src="views/dist/js/assemblers.js"></script>
</body>
</html>
