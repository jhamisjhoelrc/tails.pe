<?php

require_once '../controllers/c.customers.php';
require_once '../models/m.customers.php';
require_once '../models/m.mant.php';

class AjaxCustomers
{

    /* Editar cliente */
    public $idCustomer;
    public function ajaxEditCustomers()
    {
        $item = 'id';
        $value = $this->idCustomer;
        $response = ControllerCustomers::ctrShowCustomers($item, $value);
        echo json_encode($response);
    }


    /* Activar o desactivar cliente */
    public $activateUser;
    public $activateId;
    public function ajaxActivateCustomer()
    {
        $table = 'customers';
        $item1 = 'status';
        $value1 = $this->activateUser;
        $item2 = 'id';
        $value2 = $this->activateId;
        $response = ModelMant::mdlUpdate($table, $item1, $value1, $item2, $value2);
    }
}


/* Editar usuario */
if (isset($_POST['idCustomer'])) {
    $edit = new AjaxCustomers();
    $edit->idCustomer = $_POST['idCustomer'];
    $edit->ajaxEditCustomers();
}


/* Activar o desactivar cliente */
if (isset($_POST['activateId'])) {
    $activateU = new AjaxCustomers();
    $activateU->activateUser = $_POST['activateUser'];
    $activateU->activateId = $_POST['activateId'];
    $activateU->ajaxActivateCustomer();
}

