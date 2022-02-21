<?php

require_once "../controllers/c.notas.php";
require_once "../models/m.notas.php";
require_once "../models/m.rc.php";

class TableNotas
{

    # MOSTRAR TABLA DE NOTAS
    public function ajaxTableNotas()
    {
        $item = null;
        $value = null;
        $notas = ControllerNotas::ctrShowNotas($item, $value);

        if(empty($notas)){
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
                for ($i = 0; $i < count($notas); $i++) {
                    if($notas[$i]['type_reference'] == '01'){
                        if($notas[$i]['status_response'] == 'SIGNED'){
                            if($notas[$i]['status_document'] == 'AC_03'){
                                $status = "<td><button class='btn btn-success btn-xs'>Aceptado</button></td>";
                                $generate = "<td><a href='" . $notas[$i]["pdf_file"] . "' target='_blank' class='btn btn-default btn-xs'>pdf</a></td>";
                                $dissableEdit = 'disabled';
                            } else if($notas[$i]['status_document'] == 'PE_09'){
                                $status = "<td><button class='btn btn-warning btn-xs'>Pendiente</button></td>";
                                $generate = '';
                                $dissableEdit = '';
                            } else {
                                $status = "<td><button class='btn btn-danger btn-xs'>Rechazado</button></td>";
                                $generate = '';
                                $dissableEdit = '';
                            }
                            
                        } else {
                            $status = "<td><button class='btn btn-danger btn-xs'>Error</button></td>";
                            $generate = "<td><button class='btn btn-info btn-xs btnShowObs' idInvoicing='" . $notas[$i]["id_invoicing"] . "' data-toggle='modal' data-target='#modalShowObs'>Observación</button></td>";
                            $dissableEdit = '';
                        }
                    } else if($notas[$i]['type_reference'] == '03') {
                        $voucher_affected = $notas[$i]['serial_number'].'-'.$notas[$i]['correlative'];
                        $type = $notas[$i]['document_type'];
                        $consult_rc = ModelRc::mdlShowRc('rc', 'voucher_affected', $voucher_affected, $type);
                        if($consult_rc['status_response'] == 'SIGNED'){
                            if($consult_rc['status_document'] == 'AC_03'){
                                $status = "<td><button class='btn btn-success btn-xs'>rc-Aceptado</button></td>";
                                $generate = "<td><a href='" . $notas[$i]["pdf_file"] . "' target='_blank' class='btn btn-dark btn-xs'>pdf</a></td>";
                                $dissableEdit = 'disabled';
                            } else if($consult_rc['status_document'] == 'PE_02'){
                                $status = "<td><button class='btn btn-warning btn-xs'>rc-Pendiente</button></td>";
                                $generate = '';
                                $dissableEdit = 'disabled';
                            } else {
                                $status = "<td><button class='btn btn-danger btn-xs'>rc-Rechazado</button></td>";
                                $generate = '';
                                $dissableEdit = 'disabled';
                            }
                            
                        } else {
                            $status = "<td><button class='btn btn-danger btn-xs'>rc-Error</button></td>";
                            $generate = '';
                            $dissableEdit = 'disabled';
                        }
                    }
                    if($notas[$i]['currency'] == 'PEN'){
                        $currency = 'Soles';
                    }else {
                        $currency = 'Dólares';
                    }
                    
                    if($notas[$i]['type_voucher'] == '07'){
                        $voucher = 'N crédito';
                    }else if ($notas[$i]['type_voucher'] == '08'){
                        $voucher = 'N débito';
                    }
                    
                    $boton = "<div class='btn-group'><button class='btn btn-info btnShowNotas' idNota='" . $notas[$i]["id"] . "'><i class='fas fa-eye'></i></button></div>";
    
                    $datosJson .= '[
                                "' . ($i + 1) . '",
                                "' . $notas[$i]['customer'] . '",
                                "' . $notas[$i]['payment_condition'] . '",
                                "' . $currency . '",
                                "' . $notas[$i]['total_price'] . '",
                                "' . $voucher . '",
                                "' . $notas[$i]['serial_number'].'-'.$notas[$i]['correlative'] . '",
                                "' . $notas[$i]['date_sale'] . '",
                                "' . $notas[$i]['reference'] . '",
                                "' . $notas[$i]['motive'] . '",
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

/* Activar tabla de notas */
$activateNotas = new TableNotas();
$activateNotas->ajaxTableNotas();
