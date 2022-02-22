<?php

require_once 'connection.php';

class ModelRc
{
    # CREACION DE NUEVAS RC
    static public function mdlCreateRc($table, $affected, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:id_invoicing, :voucher_affected, :type_voucher_affected, 1, :user_create, :date_create, null, null)");
        
        $statement->bindParam(":id_invoicing", $data['id_invoicing'], PDO::PARAM_INT);
        $statement->bindParam(":voucher_affected", $affected['voucher_affected'], PDO::PARAM_STR);
        $statement->bindParam(":type_voucher_affected", $affected['type_voucher_affected'], PDO::PARAM_STR);
        $statement->bindParam(":user_create", $data['user_create'], PDO::PARAM_INT);
        $statement->bindParam(":date_create", $data['date_create'], PDO::PARAM_STR);

        if ($statement->execute()) {
            return 'ok';
        }else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA MOSTRAR LOS RESUMENES DE COMPROBANTES
    static public function mdlShowRc($table, $item, $value, $type)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT i.id, i.document_type, i.serial_number, i.correlative, i.status_response, i.status_document, i.message_response, rc.voucher_affected, rc.type_voucher_affected, rc.status
            FROM invoicing i INNER JOIN $table rc ON i.id = rc.id_invoicing
            WHERE rc.$item = :$item AND rc.type_voucher_affected = :type");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->bindParam(":type", $type, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT i.id, i.document_type, i.serial_number, i.correlative, i.status_response, i.status_document, i.message_response, rc.voucher_affected, rc.type_voucher_affected, rc.status
            FROM invoicing i INNER JOIN rc rc ON i.id = rc.id_invoicing
            WHERE rc.status != 3 ORDER BY rc.id DESC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }
}