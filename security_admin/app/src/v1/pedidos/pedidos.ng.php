<?php
include('./../../../php/header-access.php');

include('./../../../php/functions.php');
include('./../../../controllers/query/querys.C.php');
include('./../../../models/query/querys.M.php');

class ajaxPedidos
{
    /*=============================================
        LIST PEDIDOS
=============================================*/
    public $lsPedido;
    public function ajaxListPedidos()
    {

        $data = $this->lsPedido;
        //echo $data;
        echo '
            [{"names":"fernando antonio ",
            "last_name":"lopez sotomayor",
            "price":25.50,
            "codigo":"FD-00001",
            "fecha_registro":"2022-02-21 20:13:35",
            "estado":"PENDIENTE"}]
        ';
    }
}
/*=============================================
---LIST PEDIDOS
=============================================*/
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $request = json_decode(file_get_contents('php://input'), true);

    // if (isset($request)) {
        if (isset($_GET["id"])) {
            $listPedido = new ajaxPedidos();
            $listPedido->lsPedido = $_GET["id"];
            $listPedido->ajaxListPedidos();
            //echo $_GET["id"];
        // }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
} else {
    echo '[
  {
    "0": "error",
    "sms": "error",
    "detail": "view not found"
  }
]';
}
