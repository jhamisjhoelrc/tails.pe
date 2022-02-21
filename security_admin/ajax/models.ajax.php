<?php

require_once '../controllers/c.models.php';
require_once '../models/m.models.php';
require_once '../models/m.mant.php';

class AjaxModel
{

    /* Editar modelo */
    public $idModel;
    public function ajaxEditModel()
    {
        $item = 'id';
        $value = $this->idModel;
        $response = ControllerModel::ctrShowModel($item, $value);
        echo json_encode($response);
    }

}


/* Editar modelo */
if (isset($_POST['idModel'])) {
    $edit = new AjaxModel();
    $edit->idModel = $_POST['idModel'];
    $edit->ajaxEditModel();
}

