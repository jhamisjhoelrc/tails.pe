<?php

require_once 'connection.php';

class ModelSeller {


    # MOSTRAR VENDEDORES
    static public function mdlShowSeller($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT s.id,s.names,s.email,s.phone,s.id_document,s.document_number,s.status,d.description 'document'
            FROM $table s INNER JOIN documents_type d ON s.id_document = d.id 
            WHERE s.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT s.id,s.names,s.email,s.phone,s.id_document,s.document_number,s.status,d.description 'document'
            FROM $table s INNER JOIN documents_type d ON s.id_document = d.id 
            WHERE s.status != 3 ORDER BY s.id ASC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # CREACION DE NUEVOS VENDEDORES AL SISTEMA
    static public function mdlCreateSeller($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:names,:email,:phone,:id_document,:document_number,1,:user_create,:date_create,null,null)");

        $statement->bindParam(":names", $data['names'], PDO::PARAM_STR);
        $statement->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $statement->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
        $statement->bindParam(":id_document", $data['id_document'], PDO::PARAM_INT);
        $statement->bindParam(":document_number", $data['document_number'], PDO::PARAM_STR);
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

    # EDITAR VENDEDORES DEL SISTEMA
    static public function mdlEditSeller($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET names = :names, email = :email, phone = :phone, id_document = :id_document, document_number = :document_number, user_update = :user_update, date_update = :date_update WHERE email = :email ");

        $statement->bindParam(":names", $data['names'], PDO::PARAM_STR);
        $statement->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $statement->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
        $statement->bindParam(":id_document", $data['id_document'], PDO::PARAM_INT);
        $statement->bindParam(":document_number", $data['document_number'], PDO::PARAM_STR);
        $statement->bindParam(":user_update", $data['user_update'], PDO::PARAM_INT);
        $statement->bindParam(":date_update", $data['date_update'], PDO::PARAM_STR);


        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }

    # ELIMINAR VENDEDOR
    static public function mdlDeleteSeller($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET status = 3 WHERE id = :id ");
        $statement->bindParam(":id", $data, PDO::PARAM_INT);

        if ($statement->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $statement->close();
        $statement = null;
    }


}