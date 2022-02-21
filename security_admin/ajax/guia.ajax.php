<?php

require_once '../controllers/c.sales.php';
require_once '../models/m.sales.php';
require_once '../models/m.mant.php';

class AjaxGuia
{

    /* FUNCION PARA BUSCAR SALES */
    public $idInvoicing;
    public function ajaxSales()
    {
        $item = 'id_invoicing';
        $value = $this->idInvoicing;
        $response = ControllerSales::ctrShowSales($item, $value);
        echo json_encode($response);
    }

    /* FUNCION PARA BUSCAR INVOICING */
    public $idInvoicingGuia;
    public function ajaxInvoicing()
    {
        $item = 'id';
        $value = $this->idInvoicingGuia;
        $response = ControllerSales::ctrShowInvoicing($item, $value);
        echo json_encode($response);
    }
}

/* RECIBIENDO DATOS PARA CONSULTAR SALES */
if (isset($_POST['idInvoicing'])) {
    $salesInvoicing = new AjaxGuia();
    $salesInvoicing->idInvoicing = $_POST['idInvoicing'];
    $salesInvoicing->ajaxSales();
}

/* RECIBIENDO DATOS PARA CONSULTAR INVOICING */
if (isset($_POST['idInvoicingGuia'])) {
    $showInvoicing = new AjaxGuia();
    $showInvoicing->idInvoicingGuia = $_POST['idInvoicingGuia'];
    $showInvoicing->ajaxInvoicing();
}
