<?php

class ControllerProvider
{
    # MOSTRAR A LOS PROVEEDORES
    static public function ctrShowProvider($item, $value)
    {
        $table = 'providers';
        $response = ModelProvider::mdlShowProvider($table, $item, $value);
        return $response;
    }

    # CREACION DE NUEVOS PROVEEDORES
    static public function ctrCreateProvider()
    {
        if (isset($_POST['nameAddProvider'])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['nameAddProvider']) &&
                preg_match('/^[0-9]*$/', $_POST['documentTypeAddProvider'])
            ) {

                $table = 'providers';

                # REGISTRAR FECHA Y HORA ACTUAL
                date_default_timezone_set('America/Lima');
                $date = date('Y-m-d');
                $hour = date('H:i:s');
                $currentDate = $date . ' ' . $hour;

                if ($_POST['numberDocumentAddProvider'] != "") {
                    $document_number = $_POST['numberDocumentAddProvider'];
                } else {
                    $document_number = null;
                }

                if ($_POST['addressAddProvider'] != "") {
                    $address = $_POST['addressAddProvider'];
                } else {
                    $address = null;
                }

                if ($_POST['emailAddProvider'] != "") {
                    $email = $_POST['emailAddProvider'];
                } else {
                    $email = null;
                }

                if ($_POST['phoneAddProvider'] != "") {
                    $phone = $_POST['phoneAddProvider'];
                } else {
                    $phone = null;
                }

                $data = array(
                    "name" => mb_strtoupper($_POST['nameAddProvider']),
                    "id_document" => $_POST['documentTypeAddProvider'],
                    "document_number" => $document_number,
                    "provider_type" => $_POST['providerTypeAddProvider'],
                    "address" => $address,
                    "email" => $email,
                    "phone" => $phone,
                    "user_create" => $_SESSION['id_user'],
                    "date_create" => $currentDate
                );


                $response = ModelProvider::mdlCreateProvider($table, $data);

                if ($response == 'ok') {
                    echo '
                        <script>
                        window.onload=function() {
                            Swal.fire({
                            icon: "success",
                            title: "Proveedor registrado",
                            text: "El proveedor ha sido registrado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                            }).then((result) => {
                            if (result.value) {
                                window.location = "providers";
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
                            title: "Error al registrar el proveedor",
                            text: "Ocurrió un error inesperado en el registro!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result) => {
                            if (result.value) {
                            window.location = "providers";
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
                    title: "Error al registrar el proveedor",
                    text: "Los campos no pueden llevar caractéres especiales!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                }).then((result) => {
                    if (result.value) {
                    window.location = "providers";
                    }
                })
                }
                </script>';
            }
        }
    }

    # ACTUALIZACION DE PROVEEDORES
    static public function ctrEditProvider()
    {
        if (isset($_POST['nameEditProvider'])) {
            if (
                preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST['nameEditProvider']) &&
                preg_match('/^[0-9]*$/', $_POST['documentTypeEditProvider'])
            ) {

                $table = 'providers';

                # REGISTRAR FECHA Y HORA ACTUAL
                date_default_timezone_set('America/Lima');
                $date = date('Y-m-d');
                $hour = date('H:i:s');
                $currentDate = $date . ' ' . $hour;

                if ($_POST['numberDocumentEditProvider'] != "") {
                    $document_number = $_POST['numberDocumentEditProvider'];
                } else {
                    $document_number = null;
                }

                if ($_POST['addressEditProvider'] != "") {
                    $address = $_POST['addressEditProvider'];
                } else {
                    $address = null;
                }

                if ($_POST['emailEditProvider'] != "") {
                    $email = $_POST['emailEditProvider'];
                } else {
                    $email = null;
                }

                if ($_POST['phoneEditProvider'] != "") {
                    $phone = $_POST['phoneEditProvider'];
                } else {
                    $phone = null;
                }

                $data = array(
                    "id" => $_POST['idProvider'],
                    "name" => mb_strtoupper($_POST['nameEditProvider']),
                    "id_document" => $_POST['documentTypeEditProvider'],
                    "document_number" => $document_number,
                    "provider_type" => $_POST['providerTypeEditProvider'],
                    "address" => $address,
                    "email" => $email,
                    "phone" => $phone,
                    "user_update" => $_SESSION['id_user'],
                    "date_update" => $currentDate
                );


                $response = ModelProvider::mdlEditProvider($table, $data);

                if ($response == 'ok') {
                    echo '
                <script>
                window.onload=function() {
                    Swal.fire({
                    icon: "success",
                    title: "Proveedor actualizado",
                    text: "El proveedor ha sido actualizado correctamente!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                    }).then((result) => {
                    if (result.value) {
                        window.location = "providers";
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
                    title: "Error al actualizar el proveedor",
                    text: "Los campos no pueden llevar caractéres especiales!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                }).then((result) => {
                    if (result.value) {
                    window.location = "providers";
                    }
                })
                }
                </script>';
            }
        }
    }

    # ELIMINAR VENDEDOR
    static public function ctrDeleteProvider()
    {
        if (isset($_GET['idProvider'])) {
            $table = 'providers';
            $data = $_GET['idProvider'];


            $response = ModelProvider::mdlDeleteProvider($table, $data);

            if ($response == 'ok') {
                echo '
            <script>
            window.onload=function() {
            Swal.fire({
                icon: "success",
                title: "Proveedor eliminado",
                text: "El proveedor ha sido borrado correctamente!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {
                window.location = "providers";
                }
            })
            }
            </script>';
            }
        }
    }
}
