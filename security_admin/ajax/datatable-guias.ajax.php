<?php

require_once "../controllers/c.guias.php";
require_once "../models/m.guias.php";


class TableGuias
{

    # MOSTRAR TABLA DE GUIAS DE REMISION
    public function ajaxTableGuias()
    {
        $item = null;
        $value = null;
        $guias = ControllerGuias::ctrShowGuias($item, $value);

        if(empty($guias)){
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
                            ""
                          ]';
            
            $datosJson .= ']
            
            }';
            echo $datosJson;
        }else {
            $datosJson = '{
                "data": [';
            for ($i = 0; $i < count($guias); $i++) {
                
                if($guias[$i]['status_response'] == 'SIGNED'){
                    if($guias[$i]['status_document'] == 'AC_03'){
                        $status = "<td><button class='btn btn-success btn-xs'>Aceptado</button></td>";
                        $generate = "<td><a href='" . $guias[$i]["pdf_file"] . "' target='_blank' class='btn btn-default btn-xs'>pdf</a></td>";
                    }else if($guias[$i]['status_document'] == 'PE_02'){
                        $status = "<td><button class='btn btn-warning btn-xs'>Pendiente</button></td>";
                        $generate = '';
                    } else {
                        $status = "<td><button class='btn btn-danger btn-xs'>Rechazado</button></td>";
                        $generate = '';
                    }
                    
                } else {
                    $status = "<td><button class='btn btn-danger btn-xs'>Error</button></td>";
                    $generate = "<td><button class='btn btn-info btn-xs btnShowObsGuia' idInvoicing='" . $guias[$i]["id_invoicing"] . "' data-toggle='modal' data-target='#modalShowObsGuia'>Observación</button></td>";
                }
                
                $boton = "<div class='btn-group'><button class='btn btn-info btnShowGuias' guiasView='" . $guias[$i]["id"] . "' style='color:white;'><i class='fas fa-eye'></i></button></div>";
                
                $datosJson .= '[
                            "' . ($i + 1) . '",
                            "' . $guias[$i]['serial_number'].'-'.$guias[$i]['correlative'] . '",
                            "' . $guias[$i]['voucher_affected'] . '",
                            "' . $guias[$i]['reason_message'] . '",
                            "' . $guias[$i]['broadcast_date'] . '",
                            "' . $guias[$i]['transfer_start_date'] . '",
                            "' . $guias[$i]['dis_entry'] . '",
                            "' . $guias[$i]['dis_arrival'] . '",
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

/* Activar tabla de guias de remisión */
$activateGuias = new TableGuias();
$activateGuias->ajaxTableGuias();
