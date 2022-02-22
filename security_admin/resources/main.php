
    <?php

    if (isset($_GET["ruta"])) {

        if ($_GET["ruta"] == "config") {
            include "resources/views/config/" . $_GET["ruta"] . ".php";
          
        }
        elseif ($_GET["ruta"] == "pedidos") {
            include "resources/views/pedidos/" . $_GET["ruta"] . ".php";
        } elseif ($_GET["ruta"] == "salir") {
            #salir login
            include "resources/views/login/salir.php";
        } elseif ($_GET["ruta"] == "dashboard") {
            include "resources/views/dashboard/" . $_GET["ruta"] . ".php";
        
        } else {
            #si no hay ruta :get error
            include "resources/error/404.php";
        }
    }else{
        include "resources/views/blank.php";
    }
    ?>
