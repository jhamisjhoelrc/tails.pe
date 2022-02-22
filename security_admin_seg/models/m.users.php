<?php

require_once 'connection.php';

class ModelUser {


    # MOSTRAR USUARIOS
    static public function mdlShowUser($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT u.id,u.names,u.last_name,u.email,u.password,u.phone,u.id_document,u.document_number,u.id_profile,u.id_subsidiary,u.photo,u.status,d.description 'document',p.description 'profile',s.description 'subsidiary'
            FROM $table u INNER JOIN documents_type d ON u.id_document = d.id 
                          INNER JOIN profiles p ON u.id_profile = p.id
                          INNER JOIN subsidiarys s ON u.id_subsidiary = s.id
            WHERE u.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT u.id,u.names,u.last_name,u.email,u.password,u.phone,u.id_document,u.document_number,u.id_profile,u.id_subsidiary,u.photo,u.status,d.description 'document',p.description 'profile',s.description 'subsidiary'
            FROM $table u INNER JOIN documents_type d ON u.id_document = d.id 
                          INNER JOIN profiles p ON u.id_profile = p.id
                          INNER JOIN subsidiarys s ON u.id_subsidiary = s.id 
            WHERE u.status != 3 ORDER BY u.id ASC");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # CREACION DE NUEVOS USUARIOS AL SISTEMA
    static public function mdlCreateUser($table, $data)
    {
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:names,:last_name,:email,:password,:phone,:id_document,:document_number,:id_profile,:id_subsidiary,:photo,1,:user_create,:date_create,null,null)");

        $statement->bindParam(":names", $data['names'], PDO::PARAM_STR);
        $statement->bindParam(":last_name", $data['last_name'], PDO::PARAM_STR);
        $statement->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $statement->bindParam(":password", $data['password'], PDO::PARAM_STR);
        $statement->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
        $statement->bindParam(":id_document", $data['id_document'], PDO::PARAM_INT);
        $statement->bindParam(":document_number", $data['document_number'], PDO::PARAM_STR);
        $statement->bindParam(":id_profile", $data['id_profile'], PDO::PARAM_INT);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":photo", $data['photo'], PDO::PARAM_STR);
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

    # EDITAR USUARIOS DEL SISTEMA
    static public function mdlEditUser($table, $data)
    {
        $statement = Connection::connect()->prepare("UPDATE $table SET names = :names, last_name = :last_name, email = :email, password = :password, phone = :phone, id_document = :id_document, document_number = :document_number, id_profile = :id_profile, id_subsidiary = :id_subsidiary, photo = :photo, user_update = :user_update, date_update = :date_update WHERE email = :email ");

        $statement->bindParam(":names", $data['names'], PDO::PARAM_STR);
        $statement->bindParam(":last_name", $data['last_name'], PDO::PARAM_STR);
        $statement->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $statement->bindParam(":password", $data['password'], PDO::PARAM_STR);
        $statement->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
        $statement->bindParam(":id_document", $data['id_document'], PDO::PARAM_INT);
        $statement->bindParam(":document_number", $data['document_number'], PDO::PARAM_STR);
        $statement->bindParam(":id_profile", $data['id_profile'], PDO::PARAM_INT);
        $statement->bindParam(":id_subsidiary", $data['id_subsidiary'], PDO::PARAM_INT);
        $statement->bindParam(":photo", $data['photo'], PDO::PARAM_STR);
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

    # ELIMINAR USUARIO
    static public function mdlDeleteUser($table, $data)
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