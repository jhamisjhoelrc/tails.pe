<?php

require_once "../controllers/c.imports.php";
require_once "../models/m.imports.php";


class TableImport
{

    # MOSTRAR TABLA DE IMPORTACIONES
    public function ajaxTableImport()
    {
        $item = null;
        $value = null;
        $imports = ControllerImport::ctrShowImport($item, $value);

        if(empty($imports)){
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
            for ($i = 0; $i < count($imports); $i++) {
                if($imports[$i]['status'] == 1){
                    $status = "<td><button class='btn btn-warning btn-xs'>Generado</button></td>";
                } else {
                    $status = "<td><button class='btn btn-success btn-xs'>Recibido</button></td>";
                }
                
                $boton = "<div class='btn-group'><button style='width:40px;' data-toggle='modal' data-target='#modalShowImport' class='btn btn-info btnShowImport' idImport='" . $imports[$i]["id"] . "' provider='" . $imports[$i]["provider"] . "' subsidiary='" . $imports[$i]["subsidiary"] . "'><i class='fas fa-eye'></i></button><a href='views/modules/downloadImports.php?reporte=".$imports[$i]["id"]."'><button class='btn btn-success' style='color:white; width:45px;'><i class='fas fa-file-excel'></i></button></a><button class='btn btn-warning btnEditImport' importsView='" . $imports[$i]["id"] . "' style='color:white;'><i class='fas fa-edit'></i></button><button class='btn btn-danger btnDeleteImport' idImport='" . $imports[$i]["id"] . "'><i class='fas fa-times'></i></button></div>";
                
                $datosJson .= '[
                            "' . ($i + 1) . '",
                            "' . $imports[$i]['provider'] . '",
                            "' . $imports[$i]['container'] . '",
                            "' . $imports[$i]['guia'] . '",
                            "' . $imports[$i]['model'] . '",
                            "' . $imports[$i]['subsidiary'] . '",
                            "' . $imports[$i]['date_emision'] . '",
                            "' . $imports[$i]['date_llegada'] . '",
                            "' . $imports[$i]['dam_total'] . '",
                            "' . $imports[$i]['real_total'] . '",
                            "' . $imports[$i]['diferent'] . '",
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

/* Activar tabla de importaciones */
$activateImport = new TableImport();
$activateImport->ajaxTableImport();
