<?php

require_once "../controllers/c.sales.php";
require_once "../models/m.sales.php";
require_once "../models/m.rc.php";


class TableSales
{

    # MOSTRAR TABLA DE VENTAS
    public function ajaxTableSales()
    {
        $item = null;
        $value = null;
        $sales = ControllerSales::ctrShowSales($item, $value);

        if(empty($sales)){
            $datosJson = '{
                "data": [';
                $datosJson .= '[
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
            for ($i = 0; $i < count($sales); $i++) {
                // PARA FACTURA
                if($sales[$i]['document_type'] == '01'){
                    // SI ESTA FIRMADO
                    if($sales[$i]['status_response'] == 'SIGNED'){
                        // SI ESTA ACEPTADO
                        if($sales[$i]['status_document'] == 'AC_03'){
                            $status = "<td><button class='btn btn-success btn-xs'>Aceptado</button></td>";
                            $generate = "<td><button class='btn btn-default btn-xs btnGuia' idSale='" . $sales[$i]["id"] . "'>Guia</button><br><a href='" . $sales[$i]["pdf_file"] . "' target='_blank' class='btn btn-default btn-xs'>pdf</a><br><a href='" . $sales[$i]["xml"] . "' target='_blank' class='btn btn-default btn-xs'>XML</a></td>";
                            $dissableEdit = 'disabled';
                        // SI ESTA PENDIENTE CON CODIGO 09
                        } else if($sales[$i]['status_document'] == 'PE_09'){
                            $status = "<td><button class='btn btn-warning btn-xs'>Pendiente</button></td>";
                            $generate = '';
                            $dissableEdit = 'disabled';
                        } 
                        // SI ESTA PENDIENTE CON CODIGO 02
                        else if($sales[$i]['status_document'] == 'PE_02'){
                        $status = "<td><button class='btn btn-warning btn-xs'>Pendiente</button></td>";
                        $generate = "<td><button class='btn btn-info btn-xs btnShowObs' idInvoicing='" . $sales[$i]["id_invoicing"] . "' data-toggle='modal' data-target='#modalShowObs'>Mensaje SUNAT</button></td>";
                        $dissableEdit = 'disabled';
                        } else {
                            $status = "<td><button class='btn btn-danger btn-xs'>Rechazado</button></td>";
                            $generate = '';
                            $dissableEdit = '';
                        }
                        
                    } else {
                        $status = "<td><button class='btn btn-danger btn-xs'>Error</button></td>";
                        $generate = "<td><button class='btn btn-info btn-xs btnShowObs' idInvoicing='" . $sales[$i]["id_invoicing"] . "' data-toggle='modal' data-target='#modalShowObs'>Observación</button></td>";
                        $dissableEdit = '';
                    }
                } else if($sales[$i]['document_type'] == '03') {
                    $voucher_affected = $sales[$i]['serial_number'].'-'.$sales[$i]['correlative'];
                    $type = $sales[$i]['document_type'];
                    $consult_rc = ModelRc::mdlShowRc('rc', 'voucher_affected', $voucher_affected, $type);
                    if($consult_rc['status_response'] == 'SIGNED'){
                        if($consult_rc['status_document'] == 'AC_03'){
                            $status = "<td><button class='btn btn-success btn-xs'>rc-Aceptado</button></td>";
                            $generate = "<td><button class='btn btn-info btn-xs btnGuia' idSale='" . $sales[$i]["id"] . "'>Guia</button><br><a href='" . $sales[$i]["pdf_file"] . "' target='_blank' class='btn btn-dark btn-xs'>pdf</a><br><a href='" . $sales[$i]["xml"] . "' target='_blank' class='btn btn-default btn-xs'>XML</a></td>";
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
                } else {
                    $status = "<td><button class='btn btn-default btn-xs'>No enviado</button></td>";
                    $generate = '';
                    $dissableEdit = '';
                }
                
                if($sales[$i]['currency'] == 'PEN'){
                    $currency = 'Soles';
                }else {
                    $currency = 'Dólares';
                }
                
                if($sales[$i]['type_voucher'] == '01'){
                    $voucher = 'Factura';
                }else if ($sales[$i]['type_voucher'] == '03'){
                    $voucher = 'Boleta';
                }
                $payd = "<td><button class='btn btn-info btn-xs btnPayd' idSales='" . $sales[$i]["id"] . "' data-toggle='modal' data-target='#modalPaydSales'>Pagos</button></td>";
                $boton = "<div class='btn-group'><button class='btn btn-warning btnEditSales' ".$dissableEdit."  salesView='" . $sales[$i]["id"] . "' style='color:white;'><i class='fas fa-edit'></i></button><button class='btn btn-info btnShowSales' salesView='" . $sales[$i]["id"] . "'><i class='fas fa-eye'></i></button><button class='btn btn-danger btnDeleteSales' salesView='" . $sales[$i]["id"] . "'><i class='fas fa-times'></i></button></div>";

                $datosJson .= '[
                            "' . ($i + 1) . '",
                            "' . $sales[$i]['customer'] . '",
                            "' . $sales[$i]['payment_condition'] . '",
                            "' . $currency . '",
                            "' . number_format($sales[$i]['total_price'],2) . '",
                            "' . $voucher . '",
                            "' . $sales[$i]['serial_number'].'-'.$sales[$i]['correlative'] . '",
                            "' . $sales[$i]['date_sale'] . '",
                            "' . $status . '",
                            "' . $generate . '",
                            "' . $payd . '",
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

/* Activar tabla de Ventas */
$activateSales = new TableSales();
$activateSales->ajaxTableSales();
