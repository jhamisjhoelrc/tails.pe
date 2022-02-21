<?php

class ControllerMovil
{
    #MOSTRAR LOS DATOS DE MOVILES
    static public function ctrShowMoviles($item, $value)
    {
      $table = 'moviles';
      $response = ModelMovil::mdlShowMoviles($table, $item, $value);
      return $response;
    }

    # FUNCION PARA ACTUALIZAR EL ENSAMBLADOR DEL MOVIL
    static public function ctrUpdateAssembler(){
      if (isset($_POST['modelAssembler'])) {
        if (
          preg_match('/^[0-9]*$/', $_POST['nameAssembler'])
        ) {
          # REGISTRAR FECHA Y HORA ACTUAL
          date_default_timezone_set('America/Lima');
          $date = date('Y-m-d');
          $hour = date('H:i:s');
          $currentDate = $date . ' ' . $hour;

          $data = array(
            'id' => $_POST['idMovil'],
            'id_assembler' => $_POST['nameAssembler'],
            'date_assembly' => $_POST['dateAssembler'],
            'observation_assembly' => $_POST['detailAssembler'],
            'user_update' => $_SESSION['id_user'],
            'date_update' => $currentDate
          );

          $response = ModelMovil::mdlUpdateAssembler('moviles', $data);

          if($response == 'ok'){
            echo '
                <script>
                window.onload=function() {
                  Swal.fire({
                    icon: "success",
                    title: "Móvil actualizado",
                    text: "Se modifico los datos del ensamblador!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                  }).then((result) => {
                    if (result.value) {
                      window.location = "moviles";
                    }
                  })
                }
                </script>';
          }else {
            echo '
            <script>
            window.onload=function() {
              Swal.fire({
                icon: "error",
                title: "Error al actualizar el movil",
                text: "Ocurró un error inesperado!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
              }).then((result) => {
                if (result.value) {
                  window.location = "moviles";
                }
              })
            }
            </script>';
          }
        }
      }
    }

     # ELIMINAR MOVILES
     static public function ctrDeleteMovil()
     {
         if (isset($_GET['idMovil'])) {
         $table = 'moviles';
         $data = $_GET['idMovil'];
 
 
         $response = ModelMovil::mdlDeleteMovil($table, $data);
 
         if ($response == 'ok') {
             echo '
             <script>
             window.onload=function() {
             Swal.fire({
                 icon: "success",
                 title: "Movil eliminado",
                 text: "El movil ha sido borrado correctamente!",
                 showConfirmButton: true,
                 confirmButtonText: "Cerrar",
                 closeOnConfirm: false
             }).then((result) => {
                 if (result.value) {
                 window.location = "moviles";
                 }
             })
             }
             </script>';
         } else {
          echo '
          <script>
          window.onload=function() {
            Swal.fire({
              icon: "error",
              title: "Error al eliminar el movil",
              text: "Ocurrió un error inesperado!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              closeOnConfirm: false
            }).then((result) => {
              if (result.value) {
                window.location = "moviles";
              }
            })
          }
          </script>';
         }
         }
     }
}