<?php

require_once "../controllers/c.exchange.php";
require_once "../models/m.exchange.php";


class TableExchange
{

    # MOSTRAR TABLA DE TIPO DE CAMBIO
    public function ajaxTableExchange()
    {
        $item = null;
        $value = null;
        $exchange = ControllerExchange::ctrShowExchange($item, $value);

        if(empty($exchange)){
            $datosJson = '{
                "data": [';
                $datosJson .= '[
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
            for ($i = 0; $i < count($exchange); $i++) {
                
                $boton = "<div class='btn-group'><button class='btn btn-warning btnEditExchange' exchangeView='" . $exchange[$i]["id"] . "' style='color:white;'><i class='fas fa-edit' data-toggle='modal' data-target='#modalEditExchange'></i></button><button class='btn btn-danger btnDeleteExchange' idExchange='" . $exchange[$i]["id"] . "'><i class='fas fa-times'></i></button></div>";
                
                $datosJson .= '[
                            "' . ($i + 1) . '",
                            "' . $exchange[$i]['value_exchange'] . '",
                            "' . $exchange[$i]['date_exchange'] . '",
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

/* ACTIVA TABLA DE TIPO DE CAMBIO */
$activateExchange = new TableExchange();
$activateExchange->ajaxTableExchange();
