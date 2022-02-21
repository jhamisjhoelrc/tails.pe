<?php

require_once '../controllers/c.imports.php';
require_once '../models/m.imports.php';
require_once '../models/m.mant.php';

class AjaxImports
{
    /* visualizar importaciones */
    public $idImport;
    public function ajaxShowImport()
    {   
        $table = 'detail_import';
        $item = 'id_import';
        $value = $this->idImport;
        $response = ControllerImport::ctrShowDetail($table, $item, $value);
        echo json_encode($response);
    }
}


/* Editar proveedor */
if (isset($_POST['idImport'])) {
    $view = new AjaxImports();
    $view->idImport = $_POST['idImport'];
    $view->ajaxShowImport();
}
