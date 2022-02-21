<?php

class ControllerNational
{
  # CREACION DE NUEVAS COMRPAS NACIONALES
  static public function ctrCreateNational()
  {
    if (isset($_POST['providerAddNational'])) {
      if (
        preg_match('/^[0-9]*$/', $_POST['providerAddNational']) &&
        preg_match('/^[0-9]*$/', $_POST['subsidiaryAddNational'])
      ) {

        $table = 'nationals';

        # REGISTRAR FECHA Y HORA ACTUAL
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $currentDate = $date . ' ' . $hour;

        $data = array(
          "id_provider" => $_POST['providerAddNational'],
          "date_emision" => $_POST['dateEmisionAddNational'],
          "date_llegada" => $_POST['dateLlegadaAddNational'],
          "id_subsidiary" => $_POST['subsidiaryAddNational'],
          "id_model" => $_POST['modelAddNational'],
          "observation" => $_POST['observationAddNational'],
          "transport_guide" => $_POST['transportsAddNational'],
          "user_create" => $_SESSION['id_user'],
          "date_create" => $currentDate
        );

        $responseCabecera = ModelNational::mdlCreateNational($table, $data);


        if (isset($_FILES["import_national_excel"]["tmp_name"])) {
          // LLAMANDO A LA LIBRERIA DE EXCEL
          include('vendor/autoload.php');
          $extension_habilitada = array('xls', 'csv', 'xlsx');
          $file_array = explode(".", $_FILES["import_national_excel"]["name"]);
          $file_extension = end($file_array);

          if (in_array($file_extension, $extension_habilitada)) {

            $file_name = time() . '.' . $file_extension;
            move_uploaded_file($_FILES['import_national_excel']['tmp_name'], $file_name);
            $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

            $spreadsheet = $reader->load($file_name);

            unlink($file_name);

            $data = $spreadsheet->getActiveSheet()->toArray();

            foreach ($data as $row) {

              if ($row[0] != '') {

                $insert_data = array(
                  ':id_national'  => $responseCabecera,
                  ':dam'  => $row[0],
                  ":chasis" => $row[1],
                  ':motor'  => $row[2],
                  ':color'  => $row[3],
                  ':fabricacion'  => $row[4]
                );

                $query = "INSERT INTO detail_national (id_national, dam, chasis, motor, color, fabricacion) VALUES (:id_national, :dam, :chasis, :motor, :color, :fabricacion)";

                $repsonseDetail = ModelNational::mdlCreateNationalDetail($query, $insert_data);

                $message = $repsonseDetail;
              }
            }
          } else {
            $message = 'error de extension';
          }
        } else {
          $message = 'error archivo vacío';
        }

        if ($message == 'ok') {
          echo '
            <script>
            window.onload=function() {
              Swal.fire({
                icon: "success",
                title: "Compra nacional registrado",
                text: "La compra nacional ha sido registrado correctamente!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
              }).then((result) => {
                if (result.value) {
                  window.location = "nationals";
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
              title: "Error al registrar la compra nacional",
              text: "Los campos no pueden llevar caractéres especiales!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              closeOnConfirm: false
            }).then((result) => {
              if (result.value) {
                window.location = "nationals";
              }
            })
          }
          </script>';
      }
    }
  }

  #MOSTRAR LOS DATOS DE COMPRAS NACIONALES
  static public function ctrShowNational($item, $value)
  {
    $table = 'nationals';
    $response = ModelNational::mdlShowNational($table, $item, $value);
    return $response;
  }

  #MOSTRAR LOS DATOS DETALLES DE COMPRAS NACIONALES
  static public function ctrShowDetail($table, $item, $value)
  {
    $response = ModelNational::mdlShowDetail($table, $item, $value);
    return $response;
  }

  #MOSTRAR LOS DATOS DE PROVEEDORES AUTORIZADOS
  static public function ctrShowProvider($item, $value)
  {
    $table = 'providers';
    $response = ModelNational::mdlShowProvider($table, $item, $value);
    return $response;
  }





  # ACTUALIZAR  COMPRAS NACIONALES
  static public function ctrEditNational()
  {
    if (isset($_POST['providerEditNational'])) {
      if (
        preg_match('/^[0-9]*$/', $_POST['providerEditNational']) &&
        preg_match('/^[0-9]*$/', $_POST['subsidiaryEditNational'])
      ) {

        $table = 'nationals';

        # REGISTRAR FECHA Y HORA ACTUAL
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $currentDate = $date . ' ' . $hour;

        $data = array(
          "id" => $_GET['nationalsView'],
          "id_provider" => $_POST['providerEditNational'],
          "date_emision" => $_POST['dateEmisionEditNational'],
          "date_llegada" => $_POST['dateLlegadaEditNational'],
          "id_subsidiary" => $_POST['subsidiaryEditNational'],
          "id_model" => $_POST['modelEditNational'],
          "observation" => $_POST['observationEditNational'],
          "transport_guide" => $_POST['transportEditNational'],
          "status" => $_POST['statusEditNational'],
          "user_update" => $_SESSION['id_user'],
          "date_update" => $currentDate
        );



        $response = ModelNational::mdlEditNational($table, $data);
        if ($response == 'ok') {
          // VERIFICAR SI EL ESTADO ES RECIBIDO
          if ($_POST['statusEditNational'] == 4) { // ESTADO RECIBIDO

            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            $consult_detail = ModelNational::mdlConsultMovilesDetail('nationals', 'id', $data['id']);
            foreach ($consult_detail as $key => $value) {
              $data_movil = array(
                'dam' => $value['dam'],
                'id_model' => $value['id_model'],
                'chasis' => $value['chasis'],
                'motor' => $value['motor'],
                'colour' => $value['color'],
                'id_subsidiary' => $value['id_subsidiary'],
                'guia' => $value['transport_guide'],
                'fabricacion' => $value['fabricacion'],
                'user_create' => $_SESSION['id_user'],
                'date_create' => $currentDate
              );

              $register_movil = ModelMovil::mdlCreateMovil('moviles', $data_movil);
            }

            echo '
                <script>
                window.onload=function() {
                  Swal.fire({
                    icon: "success",
                    title: "Nuevo stock de moviles",
                    text: "Se agrego nuevos moviles en stock!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                  }).then((result) => {
                    if (result.value) {
                      window.location = "nationals";
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
                  title: "Compra nacional actualizado",
                  text: "La compra nacional ha sido actualizado correctamente!",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar",
                  closeOnConfirm: false
                }).then((result) => {
                  if (result.value) {
                    window.location = "nationals";
                  }
                })
              }
              </script>';
          }
        }
      } else {
        echo '
          <script>
          window.onload=function() {
            Swal.fire({
              icon: "error",
              title: "Error al actualizar la compra nacional",
              text: "Los campos no pueden llevar caractéres especiales!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              closeOnConfirm: false
            }).then((result) => {
              if (result.value) {
                window.location = "nationals";
              }
            })
          }
          </script>';
      }
    }
  }

  # DESCARGAR COMPRAS NACIONALES
  static public function ctrDownloadNational()
  {
    if (isset($_GET['reporte'])) {

      $table = 'nationals';
      $item = 'id';
      $value = $_GET['reporte'];
      $responseHeader = ModelNational::mdlShowNational($table, $item, $value);
      $table2 = 'detail_national';
      $item2 = 'id_national';
      $repsonseDetail = ModelNational::mdlShowDetail($table2, $item2, $value);

      /* CREANDO EL ARCHIVO EXCEL */
      $name = 'GUIA-TRANSPORTISTA-' . $responseHeader['transport_guide'] . '.xls';
      header('Expires:0');
      header('Cache-control: private');
      header('Content-type: application/vnd.ms-excel');
      header('Cache-Control: cache, must-revalidate');
      header('Last-Modified: ' . date('D, d M Y H:i:s'));
      header('Pragma: public');
      header('Content-Disposition:; filename="' . $name . '"');
      header('Content-Transfer-Encoding: binary');

      echo utf8_decode("<table border='0'>
                            <tr>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>PROVEEDOR</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>SUCURSAL LLEGADA</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>GUIA TRANSPORTISTA</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>MODELO</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>FECHA EMISION</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>FECHA LLEGADA</td>
                            </tr>
                            <tr>
                              <td>" . $responseHeader['provider'] . "</td>
                              <td>" . $responseHeader['subsidiary'] . "</td>
                              <td>" . $responseHeader['transport_guide'] . "</td>
                              <td>" . $responseHeader['model'] . "</td>
                              <td>" . $responseHeader['date_emision'] . "</td>
                              <td>" . $responseHeader['date_llegada'] . "</td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>DAM</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>CHASIS</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>MOTOR</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>COLOR</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>FABRICACION</td>
                            </tr>");

      foreach ($repsonseDetail as $key => $value) {
        echo "<tr>
                                    <td>" . $value['dam'] . "</td>
                                    <td>" . $value['chasis'] . "</td>
                                    <td>" . $value['motor'] . "</td>
                                    <td>" . $value['color'] . "</td>
                                    <td>" . $value['fabricacion'] . "</td>
                                  </tr>";
      }

      echo "</table>";
    }
  }


  # ELIMINAR COMPRA NACIONAL
  static public function ctrDeleteNational()
  {
    if (isset($_GET['idNational'])) {
      $table = 'nationals';
      $data = $_GET['idNational'];


      $response = ModelNational::mdlDeleteNational($table, $data);

      if ($response == 'ok') {
        echo '
            <script>
            window.onload=function() {
            Swal.fire({
                icon: "success",
                title: "Compra nacional eliminada",
                text: "La compra nacional ha sido borrada correctamente!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {
                window.location = "nationals";
                }
            })
            }
            </script>';
      }
    }
  }
}
