<?php

require_once 'connection.php';

class ModelFacturation
{
    # FUNCION PARA TOMAR DATOS DE CONFIGURACIONES
    static public function mdlShowConfiguration($table)
    {
        $statement = Connection::connect()->prepare("SELECT *  FROM $table LIMIT 1");
        $statement->execute();
        return $statement->fetch();
    }

    # FUNCION PARA CONSULTAR EL ULTIMO CORRELATIVO DE LA SERIE POR TIPO DE COMPROBANTE
    static public function mdlUltimateCorrelative($table, $type, $item, $value)
    {
        $statement = Connection::connect()->prepare("SELECT max(correlative) 'correlative', status_response FROM $table
            WHERE $item = :$item AND document_type = :$type GROUP BY status_response order by id desc LIMIT 1");
        $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
        $statement->bindParam(":" . $type, $type, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    # FUNCION PARA INSERTAR EL REGISTRO A INVOICING
    static public function mdlCreateInvoicing($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null, :document_type, :serial_number, :correlative,:status_response, :status_document, :message_response, :pdf_file, :xml, :request_xml, :response_xml, :user_create, :date_create, NULL, NULL)");

        $statement->bindParam(":document_type", $data['document_type'], PDO::PARAM_STR);
        $statement->bindParam(":serial_number", $data['serial_number'], PDO::PARAM_STR);
        $statement->bindParam(":correlative", $data['correlative'], PDO::PARAM_STR);
        $statement->bindParam(":status_response", $data['status_response'], PDO::PARAM_STR);
        $statement->bindParam(":status_document", $data['status_document'], PDO::PARAM_STR);
        $statement->bindParam(":pdf_file", $data['pdf_file'], PDO::PARAM_STR);
        $statement->bindParam(":xml", $data['xml'], PDO::PARAM_STR);
        $statement->bindParam(":message_response", $data['message_response'], PDO::PARAM_STR);
        $statement->bindParam(":request_xml", $data['request_xml'], PDO::PARAM_STR);
        $statement->bindParam(":response_xml", $data['response_xml'], PDO::PARAM_STR);
        $statement->bindParam(":user_create", $data['user_create'], PDO::PARAM_INT);
        $statement->bindParam(":date_create", $data['date_create'], PDO::PARAM_STR);

        if ($statement->execute()) {
            $statement2 = Connection::connect()->prepare("SELECT max(id) 'id' FROM $table");
            $statement2->execute();
            $array_id =  $statement2->fetch();
            $id = $array_id['id'];
            return $id;
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }
}
