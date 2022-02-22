<?php

require_once 'connection.php';

class ModelProvider
{
    # MOSTRAR PROVEEDORES
    static public function mdlShowProvider($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT p.id,p.name,p.id_document,p.document_number,p.provider_type,p.address,p.email,p.phone,p.status,d.description 'document'
            FROM $table p INNER JOIN documents_type d ON p.id_document = d.id 
            WHERE p.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT p.id,p.name,p.id_document,p.document_number,p.provider_type,p.address,p.email,p.phone,p.status,d.description 'document'
            FROM $table p INNER JOIN documents_type d ON p.id_document = d.id 
            WHERE p.status != 3 ORDER BY p.id DESC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # CREACION DE NUEVOS PROVEEDORES AL SISTEMA
    static public function mdlCreateProvider($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:name,:id_document,:document_number,:provider_type,:address,:email,:phone,1,:user_create,:date_create,null,null)");

        $statement->bindParam(":name", $data['name'], PDO::PARAM_STR);
        $statement->bindParam(":id_document", $data['id_document'], PDO::PARAM_INT);
        $statement->bindParam(":document_number", $data['document_number'], PDO::PARAM_STR);
        $statement->bindParam(":provider_type", $data['provider_type'], PDO::PARAM_STR);
        $statement->bindParam(":address", $data['address'], PDO::PARAM_STR);
        $statement->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $statement->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
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

    # EDITAR PROVEEDORES DEL SISTEMA
    static public function mdlEditProvider($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET name = :name, id_document = :id_document, document_number = :document_number, provider_type = :provider_type, address = :address, email = :email, phone = :phone, user_update = :user_update, date_update = :date_update WHERE id = :id ");

        $statement->bindParam(":id", $data['id'], PDO::PARAM_INT);
        $statement->bindParam(":name", $data['name'], PDO::PARAM_STR);
        $statement->bindParam(":id_document", $data['id_document'], PDO::PARAM_INT);
        $statement->bindParam(":document_number", $data['document_number'], PDO::PARAM_STR);
        $statement->bindParam(":provider_type", $data['provider_type'], PDO::PARAM_STR);
        $statement->bindParam(":address", $data['address'], PDO::PARAM_STR);
        $statement->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $statement->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
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

    # ELIMINAR PROVEEDOR
    static public function mdlDeleteProvider($table, $data)
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
