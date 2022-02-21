<?php

class ControllerModel
{

    # FUNCION PARA LISTAR LOS MODELOS
    static public function ctrShowModel($item, $value)
    {
        $table = 'models';
        $response = ModelModel::mdlShowModel($table, $item, $value);
        return $response;
    }

    # FUNCION PARA CREAR MODELOS
    static public function ctrCreateModel(){
        if (isset($_POST['brandAddModel'])) {
            if (
                preg_match('/^[a-zA-Z0-9]*$/', $_POST['brandAddModel']) &&
                preg_match('/^[a-zA-Z0-9]*$/', $_POST['categoryAddModel'])
              ) {
                $table = 'models';
                # REGISTRAR FECHA Y HORA ACTUAL
                date_default_timezone_set('America/Lima');
                $date = date('Y-m-d');
                $hour = date('H:i:s');
                $currentDate = $date . ' ' . $hour;

                $data = array(
                "name_dua" => $_POST['nameduaAddModel'],
                "name_lucki" => $_POST['nameluckiAddModel'],
                "id_brand" => $_POST['brandAddModel'],
                "id_categories" => $_POST['categoryAddModel'],
                "user_create" => $_SESSION['id_user'],
                "date_create" => $currentDate
                );

                $response = ModelModel::mdlCreateModel($table, $data);

                if ($response == 'ok') {
                echo '
                <script>
                window.onload=function() {
                    Swal.fire({
                    icon: "success",
                    title: "Modelo registrado",
                    text: "El modelo ha sido registrado correctamente!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    }).then((result) => {
                    if (result.value) {
                        window.location = "modelo";
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
                            title: "Error al ingresar el modelo",
                            text: "Ocurró un error inesperado!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result) => {
                            if (result.value) {
                            window.location = "modelo";
                            }
                        })
                        }
                        </script>';
                }
              }
        }
    }

    # FUNCION PARA EDITAR MODELOS
    static public function ctrUpdateModel(){
        if (isset($_POST['brandEditModel'])) {
            if (
                preg_match('/^[a-zA-Z0-9]*$/', $_POST['brandEditModel']) &&
                preg_match('/^[a-zA-Z0-9]*$/', $_POST['categoryEditModel'])
              ) {
                $table = 'models';
                # REGISTRAR FECHA Y HORA ACTUAL
                date_default_timezone_set('America/Lima');
                $date = date('Y-m-d');
                $hour = date('H:i:s');
                $currentDate = $date . ' ' . $hour;

                $data = array(
                    "id" => $_POST['idModel'],
                    "name_dua" => $_POST['nameduaEditModel'],
                    "name_lucki" => $_POST['nameluckiEditModel'],
                    "id_brand" => $_POST['brandEditModel'],
                    "id_categories" => $_POST['categoryEditModel'],
                    "user_update" => $_SESSION['id_user'],
                    "date_update" => $currentDate
                );
                /* var_dump($data); */
                $response = ModelModel::mdlUpdateModel($table, $data);

                if ($response == 'ok') {
                echo '
                <script>
                window.onload=function() {
                    Swal.fire({
                    icon: "success",
                    title: "Modelo actualizado",
                    text: "El modelo ha sido actualizado correctamente!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    }).then((result) => {
                    if (result.value) {
                        window.location = "modelo";
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
                            title: "Error al actualizar el modelo",
                            text: "Ocurró un error inesperado!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result) => {
                            if (result.value) {
                            window.location = "modelo";
                            }
                        })
                        }
                        </script>';
                }
              }
        }
    }

    # FUNCION PARA ELIMINAR MODELOS
    static public function ctrDeleteModel(){
        if (isset($_GET['idModel'])) {
            $table = 'models';
            $data = $_GET['idModel'];
      
            $response = ModelModel::mdlDeleteModel($table, $data);
            if ($response == 'ok') {
              echo '
              <script>
              window.onload=function() {
                Swal.fire({
                  icon: "success",
                  title: "Modelo eliminado",
                  text: "El modelo ha sido borrado correctamente!",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar",
                  closeOnConfirm: false
                }).then((result) => {
                  if (result.value) {
                    window.location = "modelo";
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
                        title: "Error al eliminar el modelo",
                        text: "Ocurró un error inesperado!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result) => {
                        if (result.value) {
                        window.location = "modelo";
                        }
                    })
                    }
                    </script>';
            }
          }
    }
}
