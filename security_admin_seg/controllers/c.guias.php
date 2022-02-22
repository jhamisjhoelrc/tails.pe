<?php

class ControllerGuias
{
    # FUNCION PARA CREAR UNA GUIA
    static public function ctrCreateGuias()
    {
        if (isset($_POST['weightTotal'])) {
            if (
                preg_match('/^[0-9.]*$/', $_POST['weightTotal']) &&
                preg_match('/^[0-9]*$/', $_POST['transferMode'])
            ) {
                # REGISTRAR FECHA Y HORA ACTUAL
                date_default_timezone_set('America/Lima');
                $date = date('Y-m-d');
                $hour = date('H:i:s');
                $currentDate = $date . ' ' . $hour;

                // CAMPOS DETALLE DE GUIAS
                $idmoviles = ($_POST['idMovil']);

                $dataGuia = array(
                    "id_invoicing" => 0,
                    "voucher_affected" => $_POST['voucherAffected'],
                    "type_voucher_affected" => $_POST['type_voucher'],
                    "id_customer" => $_POST['id_customer'],
                    "name_customer" => $_POST['nameCustomer'],
                    "serie_subsidiary" => $_POST['serie_subsidiary'],
                    "id_subsidiary"    => $_POST['id_subsidiary'],
                    "transfer_reason" => $_POST['motivoTraslado'],
                    "reason_message" => '',
                    "weight" => $_POST['weightTotal'],
                    "transfer_mode" => $_POST['transferMode'],
                    "broadcast_date" => $_POST['dateEmision'],
                    "transfer_start_date" => $_POST['dateTraslate'],
                    "ubigeo_entry" => $_POST['districtPartida'],
                    "direction_entry" => $_POST['addressPartida'],
                    "ubigeo_arrival" => $_POST['districtLlegada'],
                    "direction_arrival" => $_POST['addressLlegada'],
                    "observation" => $_POST['observation'],
                    "plate_number" => $_POST['plateNumberTransportista'],
                    "document_type_driver" => $_POST['documentTypeAddConductor'],
                    "document_number_driver" => $_POST['documentNumberConductor'],
                    "hour" => $hour,
                    "user_create" => $_SESSION['id_user'],
                    "date_create" => $currentDate
                );


                // LLAMANDO A LA FACTURACION ELECTRONICA
                $response_bizlinks = ControllerApiFacturation::ctrSendGuias($dataGuia, $idmoviles);

                /* echo '<pre>';
                print_r($response_bizlinks);
                echo '</pre>'; */

                if ($response_bizlinks == 'vacio') {
                    echo '
                    <script>
                    window.onload=function() {
                        Swal.fire({
                        icon: "error",
                        title: "Error al registrar el comprobante",
                        text: "Bizlinks no envió el mensaje de respuesta!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        }).then((result) => {
                        if (result.value) {
                            window.location = "guiasRemision";
                        }
                        })
                    }
                    </script>';
                } else if ($response_bizlinks == 'error') {
                    echo '
                    <script>
                    window.onload=function() {
                        Swal.fire({
                        icon: "error",
                        title: "Error al registrar el comprobante",
                        text: "Error de comunicación!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        }).then((result) => {
                        if (result.value) {
                            window.location = "guiasRemision";
                        }
                        })
                    }
                    </script>';
                } else if ($response_bizlinks == 'ok_er') {
                    echo '
                    <script>
                    window.onload=function() {
                        Swal.fire({
                        icon: "error",
                        title: "Error al registrar el comprobante",
                        text: "Revisar, el comprobante contiene errores!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        }).then((result) => {
                        if (result.value) {
                            window.location = "guiasRemision";
                        }
                        })
                    }
                    </script>';
                } else {
                    echo '
                    <script>
                    window.onload=function() {
                      Swal.fire({
                        icon: "success",
                        title: "Comprobante registrado correctamente",
                        text: "El comprobante fue registrado correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                      }).then((result) => {
                        if (result.value) {
                          window.location = "guiasRemision";
                        }
                      })
                    }
                    </script>';
                }
            }
        }
    }


    # FUNCION PARA BUSCAR GUIAS DE REMISION
    static public function ctrShowGuias($item, $value)
    {
        $table = 'guias';
        $response = ModelGuias::mdlShowGuias($table, $item, $value);
        return $response;
    }
}
