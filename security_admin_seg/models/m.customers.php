<?php

require_once 'connection.php';

class ModelCustomers
{
    #MOSTRAR LOS DATOS DE LOS CLIENTES
    static public function mdlShowCustomers($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT c.id,c.names,c.id_document,c.document_number,c.email,c.phone,c.address,c.customer_type,c.status,d.description 'document_type',d.cod_sunat
                        FROM $table c
                        INNER JOIN documents_type d ON c.id_document = d.id
            WHERE c.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT c.id,c.names,c.id_document,c.document_number,c.email,c.phone,c.address,c.customer_type,c.status,d.description 'document_type'
            FROM $table c
            INNER JOIN documents_type d ON c.id_document = d.id
            WHERE c.status != 3 ORDER BY c.id ASC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # CREACION DE NUEVOS CLIENTES
    static public function mdlCreateCustomers($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:names,:id_document,:document_number,:email,:phone,:address,:customer_type, 1,:user_create,:date_create,null,null)");

        
        $statement->bindParam(":names", $data['names'], PDO::PARAM_STR);
        $statement->bindParam(":id_document", $data['id_document'], PDO::PARAM_INT);
        $statement->bindParam(":document_number", $data['document_number'], PDO::PARAM_STR);
        $statement->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $statement->bindParam(":phone", $data['phone'], PDO::PARAM_STR);
        $statement->bindParam(":address", $data['address'], PDO::PARAM_STR);
        $statement->bindParam(":customer_type", $data['customer_type'], PDO::PARAM_STR);
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

    /* ACTUALIZAR CLIENTES */
    static public function mdlEditCustomers($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET names = :names, id_document = :id_document, document_number = :document_number, email = :email, phone = :phone, address = :address, customer_type = :customer_type, user_update = :user_update, date_update = :date_update WHERE id = :id ");

        $statement->bindParam(":id", $data['id'], PDO::PARAM_INT);
        $statement->bindParam(":names", $data['names'], PDO::PARAM_STR);
        $statement->bindParam(":id_document", $data['id_document'], PDO::PARAM_INT);
        $statement->bindParam(":document_number", $data['document_number'], PDO::PARAM_STR);
        $statement->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $statement->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
        $statement->bindParam(":address", $data['address'], PDO::PARAM_STR);
        $statement->bindParam(":customer_type", $data['customer_type'], PDO::PARAM_STR);
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

     # ELIMINAR CLIENTE
     static public function mdlDeleteCustomers($table, $data)
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