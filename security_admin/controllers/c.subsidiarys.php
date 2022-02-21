<?php

class ControllerSubsidiary
{
    #MOSTRAR A LOS VENDEDORES
    static public function ctrShowSubsidiary($item, $value)
    {
        $table = 'subsidiarys';
        $response = ModelSubsidiary::mdlShowSubsidiary($table, $item, $value);
        return $response;
    }

    # CREACION DE NUEVAS SUCURSALES
    static public function ctrCreateSubsidiary()
    {
        if (isset($_POST['descriptionAddSubsidiary'])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['responsibleAddSubsidiary'])
            ) {

                $table = 'subsidiarys';

                # REGISTRAR FECHA Y HORA ACTUAL
                date_default_timezone_set('America/Lima');
                $date = date('Y-m-d');
                $hour = date('H:i:s');
                $currentDate = $date . ' ' . $hour;

                $data = array(
                    "description" => $_POST['descriptionAddSubsidiary'],
                    "address" => $_POST['addressAddSubsidiary'],
                    "phone" => $_POST['phoneAddSubsidiary'],
                    "responsible" => $_POST['responsibleAddSubsidiary'],
                    "id_district" => $_POST['districtAddSubsidiary'],
                    "user_create" => $_SESSION['id_user'],
                    "date_create" => $currentDate
                );


                $response = ModelSubsidiary::mdlCreateSubsidiary($table, $data);

                if ($response == 'ok') {
                    echo '
            <script>
            window.onload=function() {
                Swal.fire({
                icon: "success",
                title: "Sucursal registrada",
                text: "La sucursal ha sido registrada correctamente!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
                }).then((result) => {
                if (result.value) {
                    window.location = "subsidiarys";
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
                title: "Error al registrar el sucursal",
                text: "Los campos no pueden llevar caractéres especiales!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {
                window.location = "subsidiarys";
                }
            })
            }
            </script>';
            }
        }
    }

    # ACTUALIZACION DE SUCURSALES
    static public function ctrEditSubsidiary()
    {
        if (isset($_POST['descriptionEditSubsidiary'])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['responsibleEditSubsidiary'])
            ) {

                $table = 'subsidiarys';

                # REGISTRAR FECHA Y HORA ACTUAL
                date_default_timezone_set('America/Lima');
                $date = date('Y-m-d');
                $hour = date('H:i:s');
                $currentDate = $date . ' ' . $hour;

                $data = array(
                    "id" => $_POST['idSubsidiary'],
                    "description" => $_POST['descriptionEditSubsidiary'],
                    "address" => $_POST['addressEditSubsidiary'],
                    "phone" => $_POST['phoneEditSubsidiary'],
                    "responsible" => $_POST['responsibleEditSubsidiary'],
                    "id_district" => $_POST['districtEditSubsidiary'],
                    "user_update" => $_SESSION['id_user'],
                    "date_update" => $currentDate
                );


                $response = ModelSubsidiary::mdlEditSubsidiary($table, $data);

                if ($response == 'ok') {
                    echo '
            <script>
            window.onload=function() {
                Swal.fire({
                icon: "success",
                title: "Sucursal actualizada",
                text: "La sucursal ha sido actualizada correctamente!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
                }).then((result) => {
                if (result.value) {
                    window.location = "subsidiarys";
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
                title: "Error al actualizar el sucursal",
                text: "Los campos no pueden llevar caractéres especiales!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {
                window.location = "subsidiarys";
                }
            })
            }
            </script>';
            }
        }
    }

    # ELIMINAR VENDEDOR
    static public function ctrDeleteSubsidiary()
    {
        if (isset($_GET['idSubsidiary'])) {
            $table = 'subsidiarys';
            $data = $_GET['idSubsidiary'];


            $response = ModelSubsidiary::mdlDeleteSubsidiary($table, $data);

            if ($response == 'ok') {
                echo '
            <script>
            window.onload=function() {
            Swal.fire({
                icon: "success",
                title: "Sucursal eliminada",
                text: "La sucursal ha sido borrada correctamente!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {
                window.location = "subsidiarys";
                }
            })
            }
            </script>';
            }
        }
    }
}
