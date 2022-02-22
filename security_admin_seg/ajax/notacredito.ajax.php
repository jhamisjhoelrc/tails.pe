<?php

require_once '../controllers/c.sales.php';
require_once '../models/m.sales.php';
require_once '../models/m.mant.php';

class AjaxNotacredito
{
    /* FUNCION PARA BUSCAR DATOS DE LA VENTA */
    public $idInvoicing;
    public function ajaxSale()
    {
        $item = 'id_invoicing';
        $value = $this->idInvoicing;
        $response = ControllerSales::ctrShowSalesNotacredito($item, $value);
        echo json_encode($response);
    }
}

/* RECIBIENDO DATOS PARA CONSULTAR DATOS DE VENTAS */
if (isset($_POST['idInvoicing'])) {
    $show = new AjaxNotacredito();
    $show->idInvoicing = $_POST['idInvoicing'];
    $show->ajaxSale();
}
