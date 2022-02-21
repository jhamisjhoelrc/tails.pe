<?php

require_once '../controllers/c.users.php';
require_once '../models/m.users.php';
require_once '../models/m.mant.php';

class AjaxUsers
{

    /* Editar usuario */
    public $idUser;
    public function ajaxEditUser()
    {
        $item = 'id';
        $value = $this->idUser;
        $response = ControllerUser::ctrShowUser($item, $value);
        echo json_encode($response);
    }


    /* Activar o desactivar usuario */
    public $activateUser;
    public $activateId;
    public function ajaxActivateUser()
    {
        $table = 'users';
        $item1 = 'status';
        $value1 = $this->activateUser;
        $item2 = 'id';
        $value2 = $this->activateId;
        $response = ModelMant::mdlUpdate($table, $item1, $value1, $item2, $value2);
    }

    /* Validar usuario repetido */
    public $userEmail;
    public function ajaxValidateUserRepeat()
    {
        $item = 'email';
        $value = $this->userEmail;
        $response = ControllerUser::ctrShowUser($item, $value);
        echo json_encode($response);
    }
}


/* Editar usuario */
if (isset($_POST['idUser'])) {
    $edit = new AjaxUsers();
    $edit->idUser = $_POST['idUser'];
    $edit->ajaxEditUser();
}


/* Activar o desactivar usuario */
if (isset($_POST['activateId'])) {
    $activateU = new AjaxUsers();
    $activateU->activateUser = $_POST['activateUser'];
    $activateU->activateId = $_POST['activateId'];
    $activateU->ajaxActivateUser();
}

/* Validar usuario repetido */
if (isset($_POST['userEmail'])) {
    $userEmail = new AjaxUsers();
    $userEmail->userEmail = $_POST['userEmail'];
    $userEmail->ajaxValidateUserRepeat();
}
