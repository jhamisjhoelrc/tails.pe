<?php

require_once "../controllers/c.nationals.php";
require_once "../models/m.nationals.php";


class TableNational
{

    # MOSTRAR TABLA DE NATIONALS
    public function ajaxTableNational()
    {
        $item = null;
        $value = null;
        $nationals = ControllerNational::ctrShowNational($item, $value);

        if(empty($nationals)){
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
            for ($i = 0; $i < count($nationals); $i++) {
                if($nationals[$i]['status'] == 1){
                    $status = "<td><button class='btn btn-warning btn-xs'>Generado</button></td>";
                } else {
                    $status = "<td><button class='btn btn-success btn-xs'>Recibido</button></td>";
                }
                
                $boton = "<div class='btn-group'><button style='width:40px;' data-toggle='modal' data-target='#modalShowNational' class='btn btn-info btnShowNational' idNational='" . $nationals[$i]["id"] . "' provider='" . $nationals[$i]["provider"] . "' subsidiary='" . $nationals[$i]["subsidiary"] . "'><i class='fas fa-eye'></i></button><a href='views/modules/downloadNationals.php?reporte=".$nationals[$i]["id"]."'><button class='btn btn-success' style='color:white; width:45px;'><i class='fas fa-file-excel'></i></button></a><button class='btn btn-warning btnEditNational' nationalsView='" . $nationals[$i]["id"] . "' style='color:white;'><i class='fas fa-edit'></i></button><button class='btn btn-danger btnDeleteNational' idNational='" . $nationals[$i]["id"] . "'><i class='fas fa-times'></i></button></div>";
                
                $datosJson .= '[
                            "' . ($i + 1) . '",
                            "' . $nationals[$i]['provider'] . '",
                            "' . $nationals[$i]['date_emision'] . '",
                            "' . $nationals[$i]['date_llegada'] . '",
                            "' . $nationals[$i]['subsidiary'] . '",
                            "' . $nationals[$i]['model'] . '",
                            "' . $nationals[$i]['transport_guide'] . '",
                            "' . $nationals[$i]['observation'] . '",
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

/* Activar tabla de Nationals */
$activateNational = new TableNational();
$activateNational->ajaxTableNational();
