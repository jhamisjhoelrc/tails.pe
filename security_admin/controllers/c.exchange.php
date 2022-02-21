<?php

class ControllerExchange {
    # FUNCION PARA CREAR NUEVO TIPO DE CAMBIO
    static public function ctrCreateExchange(){
      if (isset($_POST['valueExchange'])) {
        if (
            preg_match('/^[0-9.]*$/', $_POST['valueExchange'])
        ) {
          # REGISTRAR FECHA Y HORA ACTUAL
          date_default_timezone_set('America/Lima');
          $date = date('Y-m-d');
          $hour = date('H:i:s');
          $currentDate = $date . ' ' . $hour;

          $dataExchange = array(
            'value_exchange' => $_POST['valueExchange'],
            'date_exchange' => $_POST['dateExchange'],
            'user_create' => $_SESSION['id_user'],
            'date_create' => $currentDate
          );

          $responseExchange = ModelExchange::mdlCreateExchange('exchange', $dataExchange);

          if($responseExchange == 'ok'){
            echo '
            <script>
            window.onload=function() {
              Swal.fire({
                icon: "success",
                title: "Tipo de cambio registrado",
                text: "El tipo de cambio ha sido registrado correctamente!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
              }).then((result) => {
                if (result.value) {
                  window.location = "exchange";
                }
              })
            }
            </script>';
          }

        }
      }
    }

    # FUNCION PARA CREAR TIPO DE CAMBIO PRINCIPAL
    static public function ctrCreateExchangePrincipal(){
      if (isset($_POST['valueExchangePrincipal'])) {
        if (
            preg_match('/^[0-9.]*$/', $_POST['valueExchangePrincipal'])
        ) {
          # REGISTRAR FECHA Y HORA ACTUAL
          date_default_timezone_set('America/Lima');
          $date = date('Y-m-d');
          $hour = date('H:i:s');
          $currentDate = $date . ' ' . $hour;

          $dataExchange = array(
            'value_exchange' => $_POST['valueExchangePrincipal'],
            'date_exchange' => $_POST['dateExchangePrincipal'],
            'user_create' => $_SESSION['id_user'],
            'date_create' => $currentDate
          );

          $responseExchange = ModelExchange::mdlCreateExchange('exchange', $dataExchange);

          if($responseExchange == 'ok'){
            echo '
                    <script>
                    window.onload=function() {
                      Swal.fire({
                        icon: "success",
                        title: "Tipo cambio registrado",
                        text: "El tipo de cambio ha sido creado correctamente!",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                      }).then((result) => {
                        if (result.value) {
                          window.location = "exchange";
                        }
                      })
                    }
                    </script>';
          }

        }
      }
    }

    # FUNCION PARA ACTUALIZAR EL TIPO DE CAMBIO
    static public function ctrUpdateExchange(){
        if (isset($_POST['valueExchangeEdit'])) {
            if (
                preg_match('/^[0-9.]*$/', $_POST['valueExchangeEdit'])
            ) {
                # REGISTRAR FECHA Y HORA ACTUAL
                date_default_timezone_set('America/Lima');
                $date = date('Y-m-d');
                $hour = date('H:i:s');
                $currentDate = $date . ' ' . $hour;

                $dataExchange = array(
                  'id' => $_POST['idExchange'],
                  'value_exchange' => $_POST['valueExchangeEdit'],
                  'user_update' => $_SESSION['id_user'],
                  'date_update' => $currentDate
                );

                $responseExchange = ModelExchange::mdlUpdateExchange('exchange', $dataExchange);

                if($responseExchange == 'ok'){
                  echo '
                          <script>
                          window.onload=function() {
                            Swal.fire({
                              icon: "success",
                              title: "Tipo cambio actualizado",
                              text: "El tipo de cambio ha sido actualizado correctamente!",
                              showConfirmButton: true,
                              confirmButtonText: "Cerrar",
                              closeOnConfirm: false
                            }).then((result) => {
                              if (result.value) {
                                window.location = "exchange";
                              }
                            })
                          }
                          </script>';
                }
            }
        }
    }

    # FUNCION PARA MOSTRAR EL TIPO DE CAMBIO
    static public function ctrShowExchange($item, $value){
      $table = 'exchange';
      $response = ModelExchange::mdlShowExchange($table, $item, $value);
      return $response;
    }
}