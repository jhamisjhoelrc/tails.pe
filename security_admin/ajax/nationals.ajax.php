<?php

require_once '../controllers/c.nationals.php';
require_once '../models/m.nationals.php';
require_once '../models/m.mant.php';

class AjaxNational
{
    /* visualizar compras nacionales */
    public $idNational;
    public function ajaxShowNational()
    {   
        $table = 'detail_national';
        $item = 'id_national';
        $value = $this->idNational;
        $response = ControllerNational::ctrShowDetail($table, $item, $value);
        echo json_encode($response);
    }
}


/* visualizar compras nacionales */
if (isset($_POST['idNational'])) {
    $view = new AjaxNational();
    $view->idNational = $_POST['idNational'];
    $view->ajaxShowNational();
}
