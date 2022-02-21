<?php

require_once '../controllers/c.sales.php';
require_once '../models/m.sales.php';
require_once '../models/m.mant.php';

class AjaxSales
{
    /* FUNCION PARA BUSCAR DISTRITO, PROVINCIA Y DEPARTAMENTO */
    public $idDistrict;
    public function ajaxDistricts()
    {
        $item = 'id';
        $value = $this->idDistrict;
        $response = ControllerSales::ctrShowDistricts($item, $value);
        echo json_encode($response);
    }

    /* FUNCION PARA BUSCAR INVOICING */
    public $idInvoicing;
    public function ajaxInvoicing()
    {
        $item = 'id';
        $value = $this->idInvoicing;
        $response = ControllerSales::ctrShowInvoicing($item, $value);
        echo json_encode($response);
    }

    /* FUNCION PARA CONSULTAR MONTO TOTAL A PAGAR */
    public $idSales;
    public function ajaxAmountSale()
    {
        $item = 'id';
        $value = $this->idSales;
        $response = ControllerSales::ctrShowSales($item, $value);
        echo json_encode($response);
    }

    /* FUNCION PARA CONSULTAR MOVIMIENTO DE PAGO */
    public $idSalePayd;
    public function ajaxPayd()
    {
        $item = 'id_sale';
        $value = $this->idSalePayd;
        $response = ControllerSales::ctrShowPayd($item, $value);
        echo json_encode($response);
    }

    /* FUNCION PARA CONSULTAR RUC */
    public $document_number;
    public $document_type;

    public function ajaxConsultaRuc()
    {
        $token = 'apis-token-1423.LhRaF5vpvwyiAZo-M0E0eKq0ULnxEHUj';
        $document_number = $this->document_number;
        $document_type = $this->document_type;
        $response = ControllerSales::ctrConsultaruc($token, $document_number, $document_type);
        echo json_encode($response);
    }
}

/* RECIBIENDO DATOS PARA CONSULTAR DISTRITO */
if (isset($_POST['idDistrict'])) {
    $show = new AjaxSales();
    $show->idDistrict = $_POST['idDistrict'];
    $show->ajaxDistricts();
}

/* RECIBIENDO DATOS PARA CONSULTAR INVOICING */
if (isset($_POST['idInvoicing'])) {
    $showInvoicing = new AjaxSales();
    $showInvoicing->idInvoicing = $_POST['idInvoicing'];
    $showInvoicing->ajaxInvoicing();
}

/* RECIBIENDO DATOS PARA CONSULTAR MONTO TOTAL A PAGAR */
if (isset($_POST['idSales'])) {
    $showAmount = new AjaxSales();
    $showAmount->idSales = $_POST['idSales'];
    $showAmount->ajaxAmountSale();
}

/* RECIBIENDO DATOS PARA CONSULTAR MOVIMIENTOS DE PAGO */
if (isset($_POST['idSalePayd'])) {
    $showPayd = new AjaxSales();
    $showPayd->idSalePayd = $_POST['idSalePayd'];
    $showPayd->ajaxPayd();
}

/* RECIBIENDO DATOS PARA CONSULTAR RUC */
if (isset($_POST['document_number'])) {
    $consultaruc = new AjaxSales();
    $consultaruc->document_number = $_POST['document_number'];
    $consultaruc->document_type = $_POST['document_type'];
    $consultaruc->ajaxConsultaRuc();
}