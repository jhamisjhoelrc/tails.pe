<?php

require_once 'connection.php';

class ModelGuias
{
    # CREACION DE NUEVAS GUIAS
    static public function mdlCreateGuias($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null, :id_invoicing, :voucher_affected, :type_voucher_affected, :name_customer, :transfer_reason, :reason_message, :weight, :transfer_mode, :broadcast_date, :transfer_start_date, :ubigeo_entry, :direction_entry, :ubigeo_arrival, :direction_arrival, :observation, :plate_number, :document_type_driver, :document_number_driver, 1, :user_create, :date_create, null, null)");


        $statement->bindParam(":id_invoicing", $data['id_invoicing'], PDO::PARAM_INT);
        $statement->bindParam(":voucher_affected", $data['voucher_affected'], PDO::PARAM_STR);
        $statement->bindParam(":type_voucher_affected", $data['type_voucher_affected'], PDO::PARAM_STR);
        $statement->bindParam(":name_customer", $data['name_customer'], PDO::PARAM_STR);
        $statement->bindParam(":transfer_reason", $data['transfer_reason'], PDO::PARAM_STR);
        $statement->bindParam(":reason_message", $data['reason_message'], PDO::PARAM_STR);
        $statement->bindParam(":weight", $data['weight'], PDO::PARAM_STR);
        $statement->bindParam(":transfer_mode", $data['transfer_mode'], PDO::PARAM_STR);
        $statement->bindParam(":broadcast_date", $data['broadcast_date'], PDO::PARAM_STR);
        $statement->bindParam(":transfer_start_date", $data['transfer_start_date'], PDO::PARAM_STR);
        $statement->bindParam(":ubigeo_entry", $data['ubigeo_entry'], PDO::PARAM_STR);
        $statement->bindParam(":direction_entry", $data['direction_entry'], PDO::PARAM_STR);
        $statement->bindParam(":ubigeo_arrival", $data['ubigeo_arrival'], PDO::PARAM_STR);
        $statement->bindParam(":direction_arrival", $data['direction_arrival'], PDO::PARAM_STR);
        $statement->bindParam(":observation", $data['observation'], PDO::PARAM_STR);
        $statement->bindParam(":plate_number", $data['plate_number'], PDO::PARAM_STR);
        $statement->bindParam(":document_type_driver", $data['document_type_driver'], PDO::PARAM_STR);
        $statement->bindParam(":document_number_driver", $data['document_number_driver'], PDO::PARAM_STR);
        $statement->bindParam(":user_create", $data['user_create'], PDO::PARAM_INT);
        $statement->bindParam(":date_create", $data['date_create'], PDO::PARAM_STR);

        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }


    # FUNCION PARA MOSTRAR LAS GUIAS DE REMISION
    static public function mdlShowGuias($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT g.id,g.id_invoicing,g.voucher_affected,g.type_voucher_affected,g.name_customer, g.transfer_reason,g.reason_message,g.weight,g.transfer_mode,g.broadcast_date,g.transfer_start_date,g.ubigeo_entry,g.direction_entry,g.ubigeo_arrival,
            g.direction_arrival,g.observation,g.plate_number,g.document_type_driver,g.document_number_driver,g.status, i.serial_number, i.correlative, (SELECT name FROM ubigeo_peru_districts WHERE id = g.ubigeo_entry) 'dis_entry',
            (SELECT name FROM ubigeo_peru_districts WHERE id = g.ubigeo_arrival) 'dis_arrival',i.status_response, i.pdf_file,i.status_document
                        FROM $table g INNER JOIN invoicing i ON g.id_invoicing = i.id
                                     INNER JOIN ubigeo_peru_districts d ON g.ubigeo_entry = d.id
            WHERE g.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT g.id,g.id_invoicing,g.voucher_affected,g.type_voucher_affected,g.transfer_reason,g.reason_message,g.weight,g.transfer_mode,g.broadcast_date,g.transfer_start_date,g.ubigeo_entry,g.direction_entry,g.ubigeo_arrival,
            g.direction_arrival,g.observation,g.plate_number,g.document_type_driver,g.document_number_driver,g.status, i.serial_number, i.correlative, (SELECT name FROM ubigeo_peru_districts WHERE id = g.ubigeo_entry) 'dis_entry',
            (SELECT name FROM ubigeo_peru_districts WHERE id = g.ubigeo_arrival) 'dis_arrival',i.status_response, i.pdf_file,i.status_document
                        FROM $table g INNER JOIN invoicing i ON g.id_invoicing = i.id
                                     INNER JOIN ubigeo_peru_districts d ON g.ubigeo_entry = d.id
            WHERE g.status != 3 ORDER BY g.id DESC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }
}
