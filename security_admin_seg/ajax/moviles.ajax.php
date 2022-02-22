<?php

require_once '../controllers/c.movil.php';
require_once '../models/m.movil.php';
require_once '../models/m.mant.php';

class AjaxMoviles
{
    /* VISUALIZAR MOVILES */
    public $idMovil;
    public function ajaxShowMovil()
    {
        $item = 'id';
        $value = $this->idMovil;
        $response = ControllerMovil::ctrShowMoviles($item, $value);
        echo json_encode($response);
    }

    /* ACTIVAR O DESACTIVAR MOVILES */
    public $activateMovil;
    public $activateId;
    public function ajaxActivateMovil()
    {
        $table = 'moviles';
        $item1 = 'status';
        $value1 = $this->activateMovil;
        $item2 = 'id';
        $value2 = $this->activateId;
        $response = ModelMant::mdlUpdate($table, $item1, $value1, $item2, $value2);
    }
}


/* VISUALIZAR MOVILES */
if (isset($_POST['idMovil'])) {
    $view = new AjaxMoviles();
    $view->idMovil = $_POST['idMovil'];
    $view->ajaxShowMovil();
}

/* ACTIVAR O DESACTIVAR MOVILES */
if (isset($_POST['activateId'])) {
    $activateM = new AjaxMoviles();
    $activateM->activateMovil = $_POST['activateMovil'];
    $activateM->activateId = $_POST['activateId'];
    $activateM->ajaxActivateMovil();
}
