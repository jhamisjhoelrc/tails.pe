<?php

require_once '../controllers/c.subsidiarys.php';
require_once '../models/m.subsidiarys.php';
require_once '../models/m.mant.php';

class AjaxSubsidiary
{

    /* Conseguir ubigeo */
    public $idDistrict;
    public function ajaxUbigeo()
    {
        $item = 'id';
        $value = $this->idDistrict;
        $response = ModelSubsidiary::mdlShowUbigeo($item, $value);
        echo json_encode($response);
    }

    /* Editar sucursal */
    public $idSubsidiary;
    public function ajaxEditSubsidiary()
    {
        $item = 'id';
        $value = $this->idSubsidiary;
        $response = ControllerSubsidiary::ctrShowSubsidiary($item, $value);
        echo json_encode($response);
    }
}

/* Conseguir ubigeo */
if (isset($_POST['idDistrict'])) {
    $ubigeo = new AjaxSubsidiary();
    $ubigeo->idDistrict = $_POST['idDistrict'];
    $ubigeo->ajaxUbigeo();
}

/* Editar sucursal */
if (isset($_POST['idSubsidiary'])) {
    $edit = new AjaxSubsidiary();
    $edit->idSubsidiary = $_POST['idSubsidiary'];
    $edit->ajaxEditSubsidiary();
}
