<?php

require_once "../controllers/c.movil.php";
require_once "../models/m.movil.php";


class TableMoviles
{

    # MOSTRAR TABLA DE MOVILES
    public function ajaxTableMoviles()
    {
        $item = null;
        $value = null;
        $moviles = ControllerMovil::ctrShowMoviles($item, $value);

        if (empty($moviles)) {
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
        } else {
            $datosJson = '{
                "data": [';
            for ($i = 0; $i < count($moviles); $i++) {
                if ($moviles[$i]['status'] == 1) {
                    $status = "<td><button class='btn btn-default btn-xs btnActivateMovil' idMovil='" . $moviles[$i]['id'] . "' statusMovil='5'>Stock</button></td>";
                } else {
                    $status = "<td><button class='btn btn-success btn-xs btnActivateMovil' idMovil='" . $moviles[$i]['id'] . "' statusMovil='1'>Vendida</button></td>";
                }

                if ($moviles[$i]['condition_movil'] == 'desarmada') {
                    $condition_movil = "<td><button class='btn btn-default btn-xs btnAssembler' idMovil='" . $moviles[$i]["id"] . "' data-toggle='modal' data-target='#modalEditAseembler'>Desarmada</button></td>";
                } else {
                    $condition_movil = "<td><button class='btn btn-info btn-xs btnAssembler' idMovil='" . $moviles[$i]["id"] . "' data-toggle='modal' data-target='#modalEditAseembler'>Ensamblada</button></td>";
                }

                $boton = "<div class='btn-group'><button class='btn btn-danger btnDeleteMovil' idMovil='" . $moviles[$i]["id"] . "'><i class='fas fa-times'></i></button></div>";

                $datosJson .= '[
                            "' . ($i + 1) . '",
                            "' . $moviles[$i]['guia'] . '",
                            "' . $moviles[$i]['brand'] . '",
                            "' . $moviles[$i]['model'] . '",
                            "' . $moviles[$i]['chasis'] . '",
                            "' . $moviles[$i]['motor'] . '",
                            "' . $moviles[$i]['colour'] . '",
                            "' . $moviles[$i]['subsidiary'] . '",
                            "' . $condition_movil . '",
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

/* Activar tabla de moviles */
$activateMoviles = new TableMoviles();
$activateMoviles->ajaxTableMoviles();
