<?php

require_once "../controllers/c.notacredito.php";
require_once "../models/m.notacredito.php";
require_once "../models/m.rc.php";

class TableNotadebito
{

    # MOSTRAR TABLA DE NOTAS DE DEBITO
    public function ajaxTableNotadebito()
    {
        $item = null;
        $value = null;
        $notadebito = ControllerNotas::ctrShowNotadebito($item, $value);

        if(empty($notadebito)){
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
            for ($i = 0; $i < count($notadebito); $i++) {
                if($notadebito[$i]['type_voucher_affected'] == '01'){
                    if($notadebito[$i]['status_response'] == 'SIGNED'){
                        if($notadebito[$i]['status_document'] == 'AC_03'){
                            $status = "<td><button class='btn btn-success btn-xs'>Aceptado</button></td>";
                            $generate = "<td><a href='" . $notadebito[$i]["pdf_file"] . "' target='_blank' class='btn btn-dark btn-xs'>pdf</a></td>";
                        } else if($notadebito[$i]['status_document'] == 'PE_02'){
                            $status = "<td><button class='btn btn-warning btn-xs'>Pendiente</button></td>";
                            $generate = '';
                        } else {
                            $status = "<td><button class='btn btn-danger btn-xs'>Rechazado</button></td>";
                            $generate = '';
                        }
                        
                    } else {
                        $status = "<td><button class='btn btn-danger btn-xs'>Error</button></td>";
                        $generate = '';
                    }
                }else {
                    $voucher_affected = $notadebito[$i]['serial_number'].'-'.$notadebito[$i]['correlative'];
                    $type = $notadebito[$i]['document_type'];
                    $consult_rc = ModelRc::mdlShowRc('rc', 'voucher_affected', $voucher_affected, $type);
                    if($consult_rc['status_response'] == 'SIGNED'){
                        if($consult_rc['status_document'] == 'AC_03'){
                            $status = "<td><button class='btn btn-success btn-xs'>rc-Aceptado</button></td>";
                            $generate = "<td><button class='btn btn-info btn-xs btnGuia' idSale='" . $notadebito[$i]["id"] . "'>Guia</button><br><a href='" . $notadebito[$i]["pdf_file"] . "' target='_blank' class='btn btn-dark btn-xs'>pdf</a></td>";
                        } else if($consult_rc['status_document'] == 'PE_02'){
                            $status = "<td><button class='btn btn-warning btn-xs'>rc-Pendiente</button></td>";
                            $generate = '';
                        } else {
                            $status = "<td><button class='btn btn-danger btn-xs'>rc-Rechazado</button></td>";
                            $generate = '';
                        }
                        
                    } else {
                        $status = "<td><button class='btn btn-danger btn-xs'>rc-Error</button></td>";
                        $generate = '';
                    }
                }
                
                $boton = "<div class='btn-group'><button style='width:40px;' class='btn btn-info btnShowSales' idSales='" . $notadebito[$i]["id"] . "'><i class='fas fa-eye'></i></button><button class='btn btn-warning btnEditSales' salesView='" . $notadebito[$i]["id"] . "' style='color:white;'><i class='fas fa-edit'></i></button><button class='btn btn-danger btnDeleteSales' idSales='" . $notadebito[$i]["id"] . "'><i class='fas fa-times'></i></button></div>";
                
                $datosJson .= '[
                    "' . ($i + 1) . '",
                    "' . $notadebito[$i]['serial_number'].'-'.$notadebito[$i]['correlative'] . '",
                    "' . $notadebito[$i]['reason_message'] . '",
                    "' . $notadebito[$i]['voucher_affected'] . '",
                    "' . $notadebito[$i]['name_customer'] . '",
                    "' . $notadebito[$i]['total_price'] . '",
                    "' . $notadebito[$i]['broadcast_date'] . '",
                    "' . $status . '",
                    "' . $generate . '",
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

/* Activar tabla de nota de debito */
$activateNotadebito = new TableNotadebito();
$activateNotadebito->ajaxTableNotadebito();
