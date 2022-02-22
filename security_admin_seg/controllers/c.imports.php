<?php



class ControllerImport
{
  # CREACION DE NUEVAS IMPORTACIONES
  static public function ctrCreateImport()
  {
    if (isset($_POST['providerAddImport'])) {
      if (
        preg_match('/^[0-9]*$/', $_POST['providerAddImport']) &&
        preg_match('/^[0-9]*$/', $_POST['subsidiaryAddImport'])
      ) {

        $table = 'imports';

        # REGISTRAR FECHA Y HORA ACTUAL
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $currentDate = $date . ' ' . $hour;

        $data = array(
          "id_provider" => $_POST['providerAddImport'],
          "id_subsidiary" => $_POST['subsidiaryAddImport'],
          "guia" => $_POST['guiaAddImport'],
          "bl" => $_POST['blAddImport'],
          "chine_code" => $_POST['codeChineAddImport'],
          "container" => $_POST['containerAddImport'],
          "contract" => $_POST['contractAddImport'],
          "invoice_number" => $_POST['numberInvoiceAddImport'],
          "invoice_date" => $_POST['dateInvoiceAddImport'],
          "id_model" => $_POST['modelAddImport'],
          "date_zarpe" => $_POST['dateZarpeAddImport'],
          "date_arribo" => $_POST['dateArriboAddImport'],
          "date_numeration" => $_POST['dateNumerationAddImport'],
          "date_emision" => $_POST['dateEmisionAddImport'],
          "date_llegada" => $_POST['dateLlegadaAddImport'],
          "price_flete" => $_POST['priceFlete'],
          "dam_moto" => $_POST['damMoto'],
          "dam_repuesto" => $_POST['damRepuesto'],
          "dam_total" => $_POST['damTotal'],
          "real_moto" => $_POST['realMoto'],
          "real_repuesto" => $_POST['realRepuesto'],
          "real_total" => $_POST['realTotal'],
          "diferent" => $_POST['diferent'],
          "user_create" => $_SESSION['id_user'],
          "date_create" => $currentDate
        );

        $responseCabecera = ModelImport::mdlCreateImport($table, $data);


        if (isset($_FILES["import_excel"]["tmp_name"])) {
          // LLAMANDO A LA LIBRERIA DE EXCEL
          include('vendor/autoload.php');
          $extension_habilitada = array('xls', 'csv', 'xlsx');
          $file_array = explode(".", $_FILES["import_excel"]["name"]);
          $file_extension = end($file_array);

          if (in_array($file_extension, $extension_habilitada)) {

            $file_name = time() . '.' . $file_extension;
            move_uploaded_file($_FILES['import_excel']['tmp_name'], $file_name);
            $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

            $spreadsheet = $reader->load($file_name);

            unlink($file_name);

            $data = $spreadsheet->getActiveSheet()->toArray();

            foreach ($data as $row) {

              if ($row[0] != '') {

                $insert_data = array(
                  ':id_import'  => $responseCabecera,
                  ':dam'  => $row[0],
                  ":chasis" => $row[1],
                  ':motor'  => $row[2],
                  ':color'  => $row[3],
                  ':fabricacion'  => $row[4]
                );

                $query = "INSERT INTO detail_import (id_import, dam, chasis, motor, color, fabricacion) VALUES (:id_import, :dam, :chasis, :motor, :color, :fabricacion)";

                $repsonseDetail = ModelImport::mdlCreateImportDetail($query, $insert_data);

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
                title: "Importación registrado",
                text: "La importación ha sido registrado correctamente!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
              }).then((result) => {
                if (result.value) {
                  window.location = "imports";
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
              title: "Error al registrar la importación",
              text: "Los campos no pueden llevar caractéres especiales!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              closeOnConfirm: false
            }).then((result) => {
              if (result.value) {
                window.location = "imports";
              }
            })
          }
          </script>';
      }
    }
  }

  #MOSTRAR LOS DATOS DE IMPORTACIONES
  static public function ctrShowImport($item, $value)
  {
    $table = 'imports';
    $response = ModelImport::mdlShowImport($table, $item, $value);
    return $response;
  }

  #MOSTRAR LOS DATOS DETALLES DE IMPORTACIONES
  static public function ctrShowDetail($table, $item, $value)
  {
    $response = ModelImport::mdlShowDetail($table, $item, $value);
    return $response;
  }

  #MOSTRAR PROVEEDORES AUTORIZADOS
  static public function ctrShowProvider($item, $value)
  {
    $table = 'providers';
    $response = ModelImport::mdlShowProvider($table, $item, $value);
    return $response;
  }


  # ACTUALIZAR  IMPORTACIONES
  static public function ctrEditImport()
  {
    if (isset($_POST['providerEditImport'])) {
      if (
        preg_match('/^[0-9]*$/', $_POST['providerEditImport']) &&
        preg_match('/^[0-9]*$/', $_POST['subsidiaryEditImport'])
      ) {

        $table = 'imports';

        # REGISTRAR FECHA Y HORA ACTUAL
        date_default_timezone_set('America/Lima');
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        $currentDate = $date . ' ' . $hour;

        $data = array(
          "id" => $_GET['importsView'],
          "id_provider" => $_POST['providerEditImport'],
          "id_subsidiary" => $_POST['subsidiaryEditImport'],
          "guia" => $_POST['guiaEditImport'],
          "bl" => $_POST['blEditImport'],
          "chine_code" => $_POST['codeChineEditImport'],
          "container" => $_POST['containerEditImport'],
          "contract" => $_POST['contractEditImport'],
          "invoice_number" => $_POST['numberInvoiceEditImport'],
          "invoice_date" => $_POST['dateInvoiceEditImport'],
          "id_model" => $_POST['modelEditImport'],
          "date_zarpe" => $_POST['dateZarpeEditImport'],
          "date_arribo" => $_POST['dateArriboEditImport'],
          "date_numeration" => $_POST['dateNumerationEditImport'],
          "date_emision" => $_POST['dateEmisionEditImport'],
          "date_llegada" => $_POST['dateLlegadaEditImport'],
          "status" => $_POST['statusEditImport'],
          "price_flete" => $_POST['priceFlete'],
          "dam_moto" => $_POST['damMoto'],
          "dam_repuesto" => $_POST['damRepuesto'],
          "dam_total" => $_POST['damTotal'],
          "real_moto" => $_POST['realMoto'],
          "real_repuesto" => $_POST['realRepuesto'],
          "real_total" => $_POST['realTotal'],
          "diferent" => $_POST['diferent'],
          "user_update" => $_SESSION['id_user'],
          "date_update" => $currentDate
        );

        $response = ModelImport::mdlEditImport($table, $data);

        if ($response == 'ok') {
          if ($data['status'] == 4) { // ESTADO RECIBIDO
            # REGISTRAR FECHA Y HORA ACTUAL
            date_default_timezone_set('America/Lima');
            $date = date('Y-m-d');
            $hour = date('H:i:s');
            $currentDate = $date . ' ' . $hour;

            $consult_detail = ModelImport::mdlConsultMovilesDetail('imports', 'id', $data['id']);
            foreach ($consult_detail as $key => $value) {
              $data_movil = array(
                'dam' => $value['dam'],
                'id_model' => $value['id_model'],
                'chasis' => $value['chasis'],
                'motor' => $value['motor'],
                'colour' => $value['color'],
                'id_subsidiary' => $value['id_subsidiary'],
                'guia' => $value['guia'],
                'fabricacion' => $value['fabricacion'],
                'user_create' => $_SESSION['id_user'],
                'date_create' => $currentDate
              );

              // REGISTRAR EL DETALLE DE LAS COMPRAS EN MOVILES
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
                      window.location = "imports";
                    }
                  })
                }
                </script>';
          } else { // ESTADO GENERADO
            echo 'estado generado';
          }
          /* echo '
            <script>
            window.onload=function() {
              Swal.fire({
                icon: "success",
                title: "Importación actualizado",
                text: "La importación ha sido actualizado correctamente!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
              }).then((result) => {
                if (result.value) {
                  window.location = "imports";
                }
              })
            }
            </script>'; */
        }
      } else {
        echo '
          <script>
          window.onload=function() {
            Swal.fire({
              icon: "error",
              title: "Error al actualizar la importación",
              text: "Los campos no pueden llevar caractéres especiales!",
              showConfirmButton: true,
              confirmButtonText: "Cerrar",
              closeOnConfirm: false
            }).then((result) => {
              if (result.value) {
                window.location = "imports";
              }
            })
          }
          </script>';
      }
    }
  }

  # DESCARGAR IMPORTACIONES
  static public function ctrDownloadImport()
  {
    if (isset($_GET['reporte'])) {

      $table = 'imports';
      $item = 'id';
      $value = $_GET['reporte'];
      $responseHeader = ModelImport::mdlShowImport($table, $item, $value);
      $table2 = 'detail_import';
      $item2 = 'id_import';
      $repsonseDetail = ModelImport::mdlShowDetail($table2, $item2, $value);

      /* CREANDO EL ARCHIVO EXCEL */
      $name = 'GUIA-' . $responseHeader['guia'] . '.xls';
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
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>BL</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>CONTRATO</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>FECHA ZARPE</td>
                              <td style='font-weiht:bold; background-color:#E74C3C; color:white; borde: 1px solid #fff;'>FECHA LLEGADA</td>
                            </tr>
                            <tr>
                              <td>" . $responseHeader['provider'] . "</td>
                              <td>" . $responseHeader['subsidiary'] . "</td>
                              <td>" . $responseHeader['bl'] . "</td>
                              <td>" . $responseHeader['contract'] . "</td>
                              <td>" . $responseHeader['date_zarpe'] . "</td>
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


  # ELIMINAR IMPORTACIÓN
  static public function ctrDeleteImport()
  {
    if (isset($_GET['idImport'])) {
      $table = 'imports';
      $data = $_GET['idImport'];


      $response = ModelImport::mdlDeleteImport($table, $data);

      if ($response == 'ok') {
        echo '
            <script>
            window.onload=function() {
            Swal.fire({
                icon: "success",
                title: "Importación eliminada",
                text: "La importación ha sido borrada correctamente!",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {
                window.location = "imports";
                }
            })
            }
            </script>';
      }
    }
  }
}
