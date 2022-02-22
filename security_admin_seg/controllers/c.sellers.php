<?php

class ControllerSeller {

  # CREACION DE NUEVOS VENDEDORES
  static public function ctrCreateSeller()
  {
    if (isset($_POST['nameAddSeller'])) {
      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['nameAddSeller']) &&
        preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/', $_POST['emailAddSeller']) &&
        preg_match('/^[0-9]*$/', $_POST['phoneAddSeller']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['documentTypeAddSeller']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['numberDocumentAddSeller'])
      ) {

        $table = 'sellers';

        # REGISTRAR FECHA Y HORA ACTUAL
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $currentDate = $date . ' ' . $hour;

        $data = array(
          "names" => $_POST['nameAddSeller'],
          "email" => $_POST['emailAddSeller'],
          "phone" => $_POST['phoneAddSeller'],
          "id_document" => $_POST['documentTypeAddSeller'],
          "document_number" => $_POST['numberDocumentAddSeller'],
          "user_create" => $_SESSION['id_user'],
          "date_create" => $currentDate
        );
        

        $response = ModelSeller::mdlCreateSeller($table, $data);

        if ($response == 'ok') {
          echo '
          <script>
          window.onload=function() {
            Swal.fire({
              icon: "success",
              title: "Vendedor registrado",
              text: "El vendedor ha sido registrado correctamente!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              closeOnConfirm: false
            }).then((result) => {
              if (result.value) {
                window.location = "sellers";
              }
            })
          }
          </script>';
        }

      } else {
        echo '
         <script>
         window.onload=function() {
           Swal.fire({
             icon: "error",
             title: "Error al registrar el vendedor",
             text: "Los campos no pueden llevar caractéres especiales!",
             showConfirmButton: true,
             confirmButtonText: "Cerrar",
             closeOnConfirm: false
           }).then((result) => {
             if (result.value) {
               window.location = "sellers";
             }
           })
         }
         </script>';
      }
    }
  }

  # MOSTRAR A LOS VENDEDORES
  static public function ctrShowSeller($item, $value)
  {
    $table = 'sellers';
    $response = ModelSeller::mdlShowSeller($table, $item, $value);
    return $response;
  }

  # EDITAR VENDEDOR EXISTENTE
  static public function ctrEditSeller()
  {
    if (isset($_POST['nameEditSeller'])) {
      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['nameEditSeller']) &&
        preg_match('/^[0-9]*$/', $_POST['phoneEditSeller']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['documentTypeEditSeller']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['numberDocumentEditSeller'])
      ) {

        $table = 'sellers';

        # REGISTRAR FECHA Y HORA ACTUAL
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $currentDate = $date . ' ' . $hour;

        $data = array(
          "names" => $_POST['nameEditSeller'],
          "email" => $_POST['emailEditSeller'],
          "phone" => $_POST['phoneEditSeller'],
          "id_document" => $_POST['documentTypeEditSeller'],
          "document_number" => $_POST['numberDocumentEditSeller'],
          "user_update" => $_SESSION['id_user'],
          "date_update" => $currentDate
        );

        $response = ModelSeller::mdlEditSeller($table, $data);

        if ($response == 'ok') {
          echo '
          <script>
          window.onload=function() {
            Swal.fire({
              icon: "success",
              title: "Vendedor actualizado",
              text: "El vendedor ha sido actualizado correctamente!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              closeOnConfirm: false
            }).then((result) => {
              if (result.value) {
                window.location = "sellers";
              }
            })
          }
          </script>';
        }
      }
    }
  }

  # ELIMINAR VENDEDOR
  static public function ctrDeleteSeller()
  {
    if (isset($_GET['idSeller'])) {
      $table = 'sellers';
      $data = $_GET['idSeller'];


      $response = ModelSeller::mdlDeleteSeller($table, $data);

      if ($response == 'ok') {
        echo '
        <script>
        window.onload=function() {
          Swal.fire({
            icon: "success",
            title: "Vendedor eliminado",
            text: "El vendedor ha sido borrado correctamente!",
            showConfirmButton: true,
            confirmButtonText: "Cerrar",
            closeOnConfirm: false
          }).then((result) => {
            if (result.value) {
              window.location = "sellers";
            }
          })
        }
        </script>';
      }
    }
  }




}