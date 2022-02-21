<?php

require_once '../controllers/c.providers.php';
require_once '../models/m.providers.php';
require_once '../models/m.mant.php';

class AjaxProviders
{
    /* Editar proveedor */
    public $idProvider;
    public function ajaxEditProvider()
    {
        $item = 'id';
        $value = $this->idProvider;
        $response = ControllerProvider::ctrShowProvider($item, $value);
        echo json_encode($response);
    }
}


/* Editar proveedor */
if (isset($_POST['idProvider'])) {
    $edit = new AjaxProviders();
    $edit->idProvider = $_POST['idProvider'];
    $edit->ajaxEditProvider();
}
