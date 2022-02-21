<?php

require_once "../controllers/c.customers.php";
require_once "../models/m.customers.php";


class TableCustomers
{

    # MOSTRAR TABLA DE CLIENTES
    public function ajaxTableCustomers()
    {
        $item = null;
        $value = null;
        $customers = ControllerCustomers::ctrShowCustomers($item, $value);

        if(empty($customers)){
            $datosJson = '{
                "data": [';
                $datosJson .= '[
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            "",
                            ""
                          ]';
            
            $datosJson .= ']
            
            }';
            echo $datosJson;
        }else {
            $datosJson = '{
                "data": [';
            for ($i = 0; $i < count($customers); $i++) {
                if($customers[$i]['status'] == 1){
                    $status = "<td><button class='btn btn-success btn-xs btnActivateCustomers' idCustomer='".$customers[$i]["id"]."' statusCustomer='2'>Activado</button></td>";
                } else {
                    $status = "<td><button class='btn btn-danger btn-xs btnActivateCustomers' idCustomer='".$customers[$i]["id"]."' statusCustomer='1'>Inactivado</button></td>";
                }
                
                $boton = "<div class='btn-group'><button class='btn btn-warning btnEditCustomers' customersView='" . $customers[$i]["id"] . "' style='color:white;'><i class='fas fa-edit' data-toggle='modal' data-target='#modalEditCustomer'></i></button><button class='btn btn-danger btnDeleteCustomers' idCustomers='" . $customers[$i]["id"] . "'><i class='fas fa-times'></i></button></div>";
                
                $datosJson .= '[
                            "' . ($i + 1) . '",
                            "' . $customers[$i]['names'] . '",
                            "' . $customers[$i]['document_type'] . '",
                            "' . $customers[$i]['document_number'] . '",
                            "' . $customers[$i]['email'] . '",
                            "' . $customers[$i]['phone'] . '",
                            "' . $customers[$i]['address'] . '",
                            "' . $customers[$i]['customer_type'] . '",
                            "' . $status . '",
                            "' . $boton . '"
                          ],';
            }
            $datosJson = substr($datosJson, 0, -1);
            $datosJson .= ']
            
            }';
            echo $datosJson;

        }

        
    }
}

/* Activar tabla de clientes */
$activateCustomers = new TableCustomers();
$activateCustomers->ajaxTableCustomers();
