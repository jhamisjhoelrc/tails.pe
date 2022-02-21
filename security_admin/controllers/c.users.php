<?php

class ControllerUser {

    # validacion de logueo para usuarios
  static public function ctrLogin()
  {
    if (isset($_POST['emailLogin'])) {
      if (
        preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/", $_POST['emailLogin']) &&
        preg_match("/^[a-zA-Z0-9]*$/", $_POST['passwordLogin'])
      ) {
        $encrypt = crypt($_POST['passwordLogin'], '$2a$07$usesomesillystringforsalt$');
        $table = 'users';
        $item = 'email';
        $value = $_POST['emailLogin'];

        $response = ModelUser::mdlShowUser($table, $item, $value);
        if ($response['email'] == $_POST['emailLogin'] && $response['password'] == $encrypt) {

          if ($response['status'] == 1) {
            $_SESSION['loginSession'] = "enabled";
            $_SESSION['id_user'] = $response['id'];
            $_SESSION['names_user'] = $response['names'];
            $_SESSION['photo_user'] = $response['photo'];
            $_SESSION['subsidiary'] = $response['subsidiary'];
            $_SESSION['idSubsidiary'] = $response['id_subsidiary'];

            echo '<script>
                    window.location = "home"
                  </script>';

          } elseif ($response['status'] == 2) {
            echo '<br><div class="alert alert-danger alert-dismissible" role="alert">
                    <button
                      type="button"
                      class="close"
                      data-dismiss="alert"
                      aria-label="Close"
                    >
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>El usuario no está activo</strong>
                  </div>';
          } else {
            echo '<br><div class="alert alert-danger alert-dismissible" role="alert">
                    <button
                      type="button"
                      class="close"
                      data-dismiss="alert"
                      aria-label="Close"
                    >
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>El usuario no está registrado</strong>
                  </div>';
          }
        } else {
          echo '<br><div class="alert alert-danger alert-dismissible" role="alert">
                    <button
                      type="button"
                      class="close"
                      data-dismiss="alert"
                      aria-label="Close"
                    >
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Error, valide sus datos!</strong>
                  </div>';
        }
      }
    }
  }

  # CREACION DE NUEVOS USUARIOS
  static public function ctrCreateUser()
  {
    if (isset($_POST['nameAddUser'])) {
      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['nameAddUser']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['lastNameAddUser']) &&
        preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/', $_POST['emailAddUser']) &&
        preg_match('/^[0-9]*$/', $_POST['phoneAddUser']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['documentTypeAddUser']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['numberDocumentAddUser']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['profileAddUser'])
      ) {

        /* Validación de la foto */
        $route = '';
        if (isset($_FILES['newPhoto']['tmp_name'])) {

          list($width, $height) = getimagesize($_FILES['newPhoto']['tmp_name']);
          $newWidth = 128;
          $newHeight = 128;

          /* Creamos el directorio donde vamos a guardar la foto del usuario */
          $directory = 'views/dist/img/users/' . $_POST['emailAddUser'];
          mkdir($directory, 0755);

          /* Aplicando funciones por defecto de acuerdo a tipo de imagen PHP */
          if ($_FILES['newPhoto']['type'] == 'image/jpeg') {
            /* Guardando imagen en el directorio */
            $random = mt_rand(100, 999);
            $route = 'views/dist/img/users/' . $_POST['emailAddUser'] . '/user' . $random . '.jpg';
            $origin = imagecreatefromjpeg($_FILES['newPhoto']['tmp_name']);
            $destiny = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresized($destiny, $origin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagejpeg($destiny, $route);
          }

          if ($_FILES['newPhoto']['type'] == 'image/png') {
            /* Guardando imagen en el directorio */
            $random = mt_rand(100, 999);
            $route = 'views/dist/img/users/' . $_POST['emailAddUser'] . '/user' . $random . '.png';
            $origin = imagecreatefrompng($_FILES['newPhoto']['tmp_name']);
            $destiny = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresized($destiny, $origin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagepng($destiny, $route);
          }
        }

        $table = 'users';
        $encrypt = crypt($_POST['passwordAddUser'], '$2a$07$usesomesillystringforsalt$');

        # REGISTRAR FECHA Y HORA ACTUAL
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $currentDate = $date . ' ' . $hour;

        $data = array(
          "names" => $_POST['nameAddUser'],
          "last_name" => $_POST['lastNameAddUser'],
          "email" => $_POST['emailAddUser'],
          "password" => $encrypt,
          "phone" => $_POST['phoneAddUser'],
          "id_document" => $_POST['documentTypeAddUser'],
          "document_number" => $_POST['numberDocumentAddUser'],
          "id_profile" => $_POST['profileAddUser'],
          "id_subsidiary" => $_POST['subsidiaryAddUser'],
          "photo" => $route,
          "user_create" => $_SESSION['id_user'],
          "date_create" => $currentDate
        );

        $response = ModelUser::mdlCreateUser($table, $data);

        if ($response == 'ok') {
          echo '
          <script>
          window.onload=function() {
            Swal.fire({
              icon: "success",
              title: "Usuario registrado",
              text: "El usuario ha sido registrado correctamente!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              closeOnConfirm: false
            }).then((result) => {
              if (result.value) {
                window.location = "users";
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
             title: "Error al registrar el usuario",
             text: "Los campos no pueden llevar caractéres especiales!",
             showConfirmButton: true,
             confirmButtonText: "Cerrar",
             closeOnConfirm: false
           }).then((result) => {
             if (result.value) {
               window.location = "users";
             }
           })
         }
         </script>';
      }
    }
  }

  # MOSTRAR A LOS USUARIOS
  static public function ctrShowUser($item, $value)
  {
    $table = 'users';
    $response = ModelUser::mdlShowUser($table, $item, $value);
    return $response;
  }

  # EDITAR USUARIO EXISTENTE
  static public function ctrEditUser()
  {
    if (isset($_POST['nameEditUser'])) {
      if (
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['nameEditUser']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['lastNameEditUser']) &&
        preg_match('/^[0-9]*$/', $_POST['phoneEditUser']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['documentTypeEditUser']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['numberDocumentEditUser']) &&
        preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['profileEditUser'])
      ) {

        /* Validación de la foto */
        $route = $_POST['photoPresent'];

        if (isset($_FILES['editPhoto']['tmp_name']) && !empty($_FILES['editPhoto']['tmp_name'])) {

          list($width, $height) = getimagesize($_FILES['editPhoto']['tmp_name']);
          $newWidth = 128;
          $newHeight = 128;

          /* Creamos el directorio donde vamos a guardar la foto del usuario */
          $directory = 'views/dist/img/users/' . $_POST['emailEditUser'];

          /* preguntamos si existe otra imagen en la bd */
          if (!empty($_POST['photoPresent'])) {
            unlink($_POST['photoPresent']);
          } else {
            mkdir($directory, 0755);
          }

          /* Aplicando funciones por defecto de acuerdo a tipo de imagen JPG */
          if ($_FILES['editPhoto']['type'] == 'image/jpeg') {
            /* Guardando imagen en el directorio */
            $random = mt_rand(100, 999);
            $route = 'views/dist/img/users/' . $_POST['emailEditUser'] . '/' . $random . '.jpg';
            $origin = imagecreatefromjpeg($_FILES['editPhoto']['tmp_name']);
            $destiny = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresized($destiny, $origin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagejpeg($destiny, $route);
          }

          if ($_FILES['editPhoto']['type'] == 'image/png') {

            /* Guardando imagen en el directorio */
            $random = mt_rand(100, 999);
            $route = 'views/dist/img/users/' . $_POST['emailEditUser'] . '/' . $random . '.png';
            $origin = imagecreatefrompng($_FILES['editPhoto']['tmp_name']);
            $destiny = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresized($destiny, $origin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagepng($destiny, $route);
          }
        }
        $table = 'users';
        if ($_POST['passwordEditUser'] != "") {
          $encrypt = crypt($_POST['passwordEditUser'], '$2a$07$usesomesillystringforsalt$');
        } else {
          $encrypt = $_POST['passwordPresent'];
        }

        # REGISTRAR FECHA Y HORA ACTUAL
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $currentDate = $date . ' ' . $hour;

        $data = array(
          "names" => $_POST['nameEditUser'],
          "last_name" => $_POST['lastNameEditUser'],
          "email" => $_POST['emailEditUser'],
          "password" => $encrypt,
          "phone" => $_POST['phoneEditUser'],
          "id_document" => $_POST['documentTypeEditUser'],
          "document_number" => $_POST['numberDocumentEditUser'],
          "id_profile" => $_POST['profileEditUser'],
          "id_subsidiary" => $_POST['subsidiaryEditUser'],
          "photo" => $route,
          "user_update" => $_SESSION['id_user'],
          "date_update" => $currentDate
        );

        $response = ModelUser::mdlEditUser($table, $data);

        if ($response == 'ok') {
          echo '
          <script>
          window.onload=function() {
            Swal.fire({
              icon: "success",
              title: "Usuario actualizado",
              text: "El usuario ha sido actualizado correctamente!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              closeOnConfirm: false
            }).then((result) => {
              if (result.value) {
                window.location = "users";
              }
            })
          }
          </script>';
        }
      }
    }
  }

  # ELIMINAR USUARIO
  static public function ctrDeleteUser()
  {
    if (isset($_GET['idUser'])) {
      $table = 'users';
      $data = $_GET['idUser'];

      if ($_GET['photo'] != "") {
        unlink($_GET['photo']);
        rmdir('views/dist/img/users/' . $_GET['email']);
      }

      $response = ModelUser::mdlDeleteUser($table, $data);
      if ($response == 'ok') {
        echo '
        <script>
        window.onload=function() {
          Swal.fire({
            icon: "success",
            title: "Usuario eliminado",
            text: "El usuario ha sido borrado correctamente!",
            showConfirmButton: true,
            confirmButtonText: "Cerrar",
            closeOnConfirm: false
          }).then((result) => {
            if (result.value) {
              window.location = "users";
            }
          })
        }
        </script>';
      }
    }
  }




}