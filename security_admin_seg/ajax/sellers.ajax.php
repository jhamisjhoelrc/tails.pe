<?php

require_once '../controllers/c.sellers.php';
require_once '../models/m.sellers.php';
require_once '../models/m.mant.php';

class AjaxSellers
{

    /* Editar vendedor */
    public $idSeller;
    public function ajaxEditSeller()
    {
        $item = 'id';
        $value = $this->idSeller;
        $response = ControllerSeller::ctrShowSeller($item, $value);
        echo json_encode($response);
    }


    /* Activar o desactivar vendedor */
    public $activateSeller;
    public $activateId;
    public function ajaxActivateSeller()
    {
        $table = 'sellers';
        $item1 = 'status';
        $value1 = $this->activateSeller;
        $item2 = 'id';
        $value2 = $this->activateId;
        $response = ModelMant::mdlUpdate($table, $item1, $value1, $item2, $value2);
    }

    /* Validar vendedor repetido */
    public $numberDocumentSeller;
    public function ajaxValidateSellerRepeat()
    {
        $item = 'email';
        $value = $this->numberDocumentSeller;
        $response = ControllerSeller::ctrShowSeller($item, $value);
        echo json_encode($response);
    }
}


/* Editar vendedor */
if (isset($_POST['idSeller'])) {
    $edit = new AjaxSellers();
    $edit->idSeller = $_POST['idSeller'];
    $edit->ajaxEditSeller();
}


/* Activar o desactivar vendedor */
if (isset($_POST['activateId'])) {
    $activateSeller = new AjaxSellers();
    $activateSeller->activateSeller = $_POST['activateSeller'];
    $activateSeller->activateId = $_POST['activateId'];
    $activateSeller->ajaxActivateSeller();
}

/* Validar vendedor repetido */
if (isset($_POST['numberDocumentSeller'])) {
    $numberDocumentSeller = new AjaxSellers();
    $numberDocumentSeller->numberDocumentSeller = $_POST['numberDocumentSeller'];
    $numberDocumentSeller->ajaxValidateSellerRepeat();
}

