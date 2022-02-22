<?php

class ControllerAssembler
{

    # FUNCION PARA LISTAR LOS ENSAMBLADORES
    static public function ctrShowAssembler($item, $value)
    {
        $table = 'assemblers';
        $response = ModelAssembler::mdlShowAssembler($table, $item, $value);
        return $response;
    }

    # FUNCION PARA CREAR ENSAMBLADORES
    static public function ctrCreateAssembler()
    {
        if (isset($_POST['namesAddAssembler'])) {
            $table = 'assemblers';
            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            $data = array(
                "names" => $_POST['namesAddAssembler'],
                "status" => 1,
                "user_create" => $_SESSION['id_user'],
                "date_create" => $currentDate
            );

            $response = ModelAssembler::mdlCreateAssembler($table, $data);

            if ($response == 'ok') {
                echo '
                <script>
                window.onload=function() {
                    Swal.fire({
                    icon: "success",
                    title: "Ensamblador registrado",
                    text: "El Ensamblador ha sido registrado correctamente!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    }).then((result) => {
                    if (result.value) {
                        window.location = "assemblers";
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
                            title: "Error al ingresar el ensamblador",
                            text: "Ocurró un error inesperado!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result) => {
                            if (result.value) {
                            window.location = "assemblers";
                            }
                        })
                        }
                        </script>';
            }
        }
    }

    # FUNCION PARA EDITAR ENSAMBLADORES
    static public function ctrUpdateAssembler()
    {
        if (isset($_POST['namesEditAssembler'])) {
            $table = 'assemblers';
            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            $data = array(
                "id" => $_POST['idAssembler'],
                "names" => $_POST['namesEditAssembler'],
                "user_update" => $_SESSION['id_user'],
                "date_update" => $currentDate
            );
            
            $response = ModelAssembler::mdlUpdateAssembler($table, $data);

            if ($response == 'ok') {
                echo '
                <script>
                window.onload=function() {
                    Swal.fire({
                    icon: "success",
                    title: "Ensamblador actualizado",
                    text: "El ensamblador ha sido actualizado correctamente!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    }).then((result) => {
                    if (result.value) {
                        window.location = "assemblers";
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
                            title: "Error al actualizar el ensamblador",
                            text: "Ocurró un error inesperado!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result) => {
                            if (result.value) {
                            window.location = "assemblers";
                            }
                        })
                        }
                        </script>';
            }
        }
    }

    # FUNCION PARA ELIMINAR ENSAMBLADOR
    static public function ctrDeleteAssembler()
    {
        if (isset($_GET['idAssembler'])) {
            $table = 'assemblers';
            $data = $_GET['idAssembler'];

            $response = ModelAssembler::mdlDeleteAssembler($table, $data);
            if ($response == 'ok') {
                echo '
              <script>
              window.onload=function() {
                Swal.fire({
                  icon: "success",
                  title: "Ensamblador eliminado",
                  text: "El ensamblador ha sido borrado correctamente!",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar",
                  closeOnConfirm: false
                }).then((result) => {
                  if (result.value) {
                    window.location = "assemblers";
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
                        title: "Error al eliminar el ensamblador",
                        text: "Ocurró un error inesperado!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result) => {
                        if (result.value) {
                        window.location = "assemblers";
                        }
                    })
                    }
                    </script>';
            }
        }
    }
}
