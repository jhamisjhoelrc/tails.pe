<?php

class ControllerCustomers {
    

    #MOSTRAR LOS DATOS DE CLIENTES
    static public function ctrShowCustomers($item, $value)
    {
      $table = 'customers';
      $response = ModelCustomers::mdlShowCustomers($table, $item, $value);
      return $response;
    }


    # CREACION DE NUEVO CLIENTE
    static public function ctrCreateCustomers(){
        if (isset($_POST['nameAddCustomer'])) {
            if (
                preg_match('/^[0-9]*$/', $_POST['documentTypeAddCustomer'])
              ) {
                    $table = 'customers';
                    # REGISTRAR FECHA Y HORA ACTUAL
                    date_default_timezone_set('America/Lima');
                    $date = date('Y-m-d');
                    $hour = date('H:i:s');
                    $currentDate = $date . ' ' . $hour;

                    $data = array(
                        "names" => strtoupper($_POST['nameAddCustomer']),
                        "id_document" => $_POST['documentTypeAddCustomer'],
                        "document_number" => $_POST['numberDocumentAddCustomer'],
                        "email" => $_POST['emailAddCustomer'],
                        "phone" => $_POST['phoneAddCustomer'],
                        "address" => $_POST['addressAddCustomer'],
                        "customer_type" => $_POST['customerTypeAddCustomer'],
                        "user_create" => $_SESSION['id_user'],
                        "date_create" => $currentDate
                    );
                    
                    $response = ModelCustomers::mdlCreateCustomers($table, $data);

                    if ($response == 'ok') {
                        echo '
                        <script>
                        window.onload=function() {
                          Swal.fire({
                            icon: "success",
                            title: "Nuevo cliente creado!",
                            text: "El cliente ha sido registrado correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                          }).then((result) => {
                            if (result.value) {
                              window.location = "customers";
                            }
                          })
                        }
                        </script>';
                      }
                    

              }
        }
    }

    # ACTUALIZAR UN CLIENTE
    static public function ctrEditCustomers(){
        if (isset($_POST['nameEditCustomer'])) {
            if (
                preg_match('/^[0-9]*$/', $_POST['documentTypeEditCustomer'])
              ) {
                    $table = 'customers';
                    # REGISTRAR FECHA Y HORA ACTUAL
                    date_default_timezone_set('America/Lima');
                    $date = date('Y-m-d');
                    $hour = date('H:i:s');
                    $currentDate = $date . ' ' . $hour;

                    $data = array(
                        "id" => $_POST['idCustomer'], 
                        "names" => strtoupper($_POST['nameEditCustomer']),
                        "id_document" => $_POST['documentTypeEditCustomer'],
                        "document_number" => $_POST['numberDocumentEditCustomer'],
                        "email" => $_POST['emailEditCustomer'],
                        "phone" => $_POST['phoneEditCustomer'],
                        "address" => $_POST['addressEditCustomer'],
                        "customer_type" => $_POST['customerTypeEditCustomer'],
                        "user_update" => $_SESSION['id_user'],
                        "date_update" => $currentDate
                    );

                    
                    $response = ModelCustomers::mdlEditCustomers($table, $data);

                    if ($response == 'ok') {
                        echo '
                        <script>
                        window.onload=function() {
                          Swal.fire({
                            icon: "success",
                            title: "Cliente actualizado!",
                            text: "El cliente ha sido actualizado correctamente",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                          }).then((result) => {
                            if (result.value) {
                              window.location = "customers";
                            }
                          })
                        }
                        </script>';
                      }
                    

              }
        }
    }

     # ELIMINAR CLIENTE
     static public function ctrDeleteCustomers()
     {
         if (isset($_GET['idCustomers'])) {
         $table = 'customers';
         $data = $_GET['idCustomers'];
 
 
         $response = ModelCustomers::mdlDeleteCustomers($table, $data);
 
         if ($response == 'ok') {
             echo '
             <script>
             window.onload=function() {
             Swal.fire({
                 icon: "success",
                 title: "Ciente eliminado",
                 text: "El cliente ha sido borrado correctamente!",
                 showConfirmButton: true,
                 confirmButtonText: "Cerrar",
                 closeOnConfirm: false
             }).then((result) => {
                 if (result.value) {
                 window.location = "customers";
                 }
             })
             }
             </script>';
         }
         }
     }

    

}