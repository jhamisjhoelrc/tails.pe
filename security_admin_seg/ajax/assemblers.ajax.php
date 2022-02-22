<?php

require_once '../controllers/c.assemblers.php';
require_once '../models/m.assemblers.php';
require_once '../models/m.mant.php';

class AjaxAssembler
{

    /* Editar ensamblador */
    public $idAssembler;
    public function ajaxEditAssembler()
    {
        $item = 'id';
        $value = $this->idAssembler;
        $response = ControllerAssembler::ctrShowAssembler($item, $value);
        echo json_encode($response);
    }

}


/* Editar ensamblador */
if (isset($_POST['idAssembler'])) {
    $edit = new AjaxAssembler();
    $edit->idAssembler = $_POST['idAssembler'];
    $edit->ajaxEditAssembler();
}

