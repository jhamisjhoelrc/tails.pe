<!-- js para peticion ajaxs o funciones-->
<script type="text/javascript" src="app/src/js/pedidos/pedidos.js"></script>


<script type="text/javascript" src="app/src/js/config/config.js"></script>

<script type="text/javascript" src="app/src/js/login/login.js"></script>

<!-- conta -->


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

<!-- script de panel maquetado -->
<script src="public/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="public/assets/js/bootstrap.bundle.min.js"></script>


<script src="public/assets/js/moment.min.js"></script>
<script src="public/assets/js/bootstrap-datetimepicker.min.js"></script>

<!-- Include Choices JavaScript -->
<script src="public/assets/vendors/choices.js/choices.min.js"></script>

<?php

// if (isset($_SESSION["logSession"]) && $_SESSION["logSession"] == "ok") { //si se crea una sesion imprime el script
//     echo '<script src="public/assets/js/main.js"></script>';//si se crea una sesion imprime el script
// }

?>
<script src="public/assets/js/main.js"></script> <!-- //correguir con inicio de sesion -->
<script>
    $(function() {
        $('#timeStar').datetimepicker({
            format: 'HH:mm:ss'
        });
        $('#datetimeStart').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#datetimeEnd').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#dateStart').datetimepicker({
            format: 'YYYY-MM'
        });
    });
</script>