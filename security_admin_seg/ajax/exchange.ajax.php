<?php

require_once '../controllers/c.exchange.php';
require_once '../models/m.exchange.php';
require_once '../models/m.mant.php';

class AjaxExchange
{

    /* EDITAR TIPO DE CAMBIO */
    public $idExchange;
    public function ajaxEditExchange()
    {
        $item = 'id';
        $value = $this->idExchange;
        $response = ControllerExchange::ctrShowExchange($item, $value);
        echo json_encode($response);
    }
}


/* EDITAR TIPO DE CAMBIO */
if (isset($_POST['idExchange'])) {
    $editE = new AjaxExchange();
    $editE->idExchange = $_POST['idExchange'];
    $editE->ajaxEditExchange();
}


