<?php

class ModelAssembler{

    # FUNCION PARA LISTAR LOS ENSAMBLADORES
    static public function mdlShowAssembler($table, $item, $value)
    {
        if ($item != null) {
            $statement = Connection::connect()->prepare("SELECT * FROM $table a WHERE a.$item = :$item");
            $statement->bindParam(":" . $item, $value, PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch();
        } else {
            $statement = Connection::connect()->prepare("SELECT * FROM $table a WHERE a.status != 3 ORDER BY a.id DESC;");
            $statement->execute();
            return $statement->fetchAll();
        }

        $statement->close();
        $statement = null;
    }

    # FUNCION PARA CREAR NUEVO ENSAMBLADORES
    static public function mdlCreateAssembler($table, $data){
        $statement = Connection::connect()->prepare("INSERT INTO $table VALUES(null,:names,:status ,:user_create ,:date_create ,null ,null)");

        $statement->bindParam(":names", $data['names'], PDO::PARAM_STR);
        $statement->bindParam(":status", $data['status'], PDO::PARAM_STR);
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

    # FUNCION PARA EDITAR ENSAMBLADORES
    static public function mdlUpdateAssembler($table, $data){
        $statement = Connection::connect()->prepare("UPDATE $table SET names = :names, user_update = :user_update, date_update = :date_update WHERE id = :id ");

        $statement->bindParam(":id", $data['id'], PDO::PARAM_INT);
        $statement->bindParam(":names", $data['names'], PDO::PARAM_STR);
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

    # FUNCION PARA ELIMINAR ENSAMBLADORES
    static public function mdlDeleteAssembler($table, $data){
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